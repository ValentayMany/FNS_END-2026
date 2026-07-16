<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $table = 'student';

    protected $fillable = [
        'student_code',
        'full_name',
        'name_prefix',
        'degree_program_id',
        'study_year',
        'gender',
        'faculty',
        'enrollment_year',
        'is_active',
        // New columns from professor's schema
        'STDID', 'TITLE', 'FRTNAME', 'LSTNAME', 'ETITLE', 'EFNAME', 'ELNAME',
        'BIRTHDATE', 'BIRTHADDR', 'CURRADDR', 'PHONE', 'EMAIL', 'COURSEID', 'FUND',
        'TALENT', 'BEFOREUNIV', 'FUTUREWISH', 'CONTPERSON', 'RELATION', 'CONTADDR',
        'CONTPHONE', 'FATHERNAME', 'FATHERAGE', 'FATHEROCC', 'FATHERADDR', 'FATHERPHONE',
        'MOTHERNAME', 'MOTHERAGE', 'MOTHEROCC', 'MOTHERADDR', 'MOTHERPHONE', 'ORIGIN',
        'NATION', 'ETHNIC', 'RELIGION', 'STYPE', 'CFROM', 'YDATE', 'WDATE', 'KDATE',
        'PSDATE', 'PCDATE', 'SISTBROTH', 'SBPHONE'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'BIRTHDATE' => 'date',
        'YDATE' => 'date',
        'WDATE' => 'date',
        'KDATE' => 'date',
        'PSDATE' => 'date',
        'PCDATE' => 'date',
    ];

    /**
     * หลักสูตรที่นักศึกษาสังกัด
     */
    public function degreeProgram(): BelongsTo
    {
        return $this->belongsTo(DegreeProgram::class);
    }

    /**
     * รายการธุรกรรม/ใบเสร็จของนักศึกษาคนนี้
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Accessor for student_code mapping to STDID
     */
    public function getStudentCodeAttribute(): ?string
    {
        return $this->STDID;
    }

    /**
     * Mutator for student_code mapping to STDID
     */
    public function setStudentCodeAttribute(?string $value): void
    {
        $this->attributes['STDID'] = $value;
    }

    /**
     * Accessor for full_name mapping to FRTNAME and LSTNAME
     */
    public function getFullNameAttribute(): string
    {
        return trim(($this->FRTNAME ?? '') . ' ' . ($this->LSTNAME ?? ''));
    }

    /**
     * Mutator for full_name mapping to FRTNAME and LSTNAME
     */
    public function setFullNameAttribute(string $value): void
    {
        $parts = preg_split('/\s+/', trim($value), 2);
        $this->attributes['FRTNAME'] = $parts[0] ?? '';
        $this->attributes['LSTNAME'] = $parts[1] ?? '';
    }

    /**
     * Accessor for name_prefix mapping to TITLE
     */
    public function getNamePrefixAttribute(): ?string
    {
        return $this->TITLE;
    }

    /**
     * Mutator for name_prefix mapping to TITLE
     */
    public function setNamePrefixAttribute(?string $value): void
    {
        $this->attributes['TITLE'] = $value;
    }

    /**
     * ชื่อเต็มพร้อมคำนำหน้า
     */
    public function getDisplayNameAttribute(): string
    {
        return trim(($this->TITLE ? $this->TITLE . ' ' : '') . $this->full_name);
    }

    /**
     * หลักสูตรของนักศึกษา (เชื่อมโยงกับอาจารย์)
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'COURSEID', 'COURSEID');
    }

    /**
     * ค้นหานักศึกษาด้วยรหัสหรือชื่อ (สำหรับ autocomplete)
     */
    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('STDID', 'LIKE', "%{$keyword}%")
              ->orWhere('FRTNAME', 'LIKE', "%{$keyword}%")
              ->orWhere('LSTNAME', 'LIKE', "%{$keyword}%")
              ->orWhere(\DB::raw("CONCAT(FRTNAME, ' ', LSTNAME)"), 'LIKE', "%{$keyword}%");
        })->where('is_active', true);
    }
}
