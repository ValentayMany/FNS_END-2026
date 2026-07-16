<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'COURSEID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'COURSEID',
        'COURSENAME',
        'LEVEL',
        'DEPTID',
    ];

    /**
     * นักศึกษาในหลักสูตรนี้
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'COURSEID', 'COURSEID');
    }

    /**
     * อัตราหน่วยกิตของหลักสูตรนี้
     */
    public function creditRates(): HasMany
    {
        return $this->hasMany(CreditRate::class, 'COURSEID', 'COURSEID');
    }
}
