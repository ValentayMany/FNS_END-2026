<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    public $timestamps = false;

    protected $fillable = ['department_name', 'department_type', 'dept_code', 'budget_amount'];

    protected $casts = [
        'budget_amount' => 'decimal:2',
    ];

    /**
     * ຊື່ພາກສ່ວນຕາມຖານຂໍ້ມູນ (department_name) ສຳລັບ dropdown / ຕາຕະລາງ.
     */
    public function displayName(): string
    {
        $n = trim((string) ($this->department_name ?? ''));
        if ($n !== '') {
            return $n;
        }

        $t = trim((string) ($this->department_type ?? ''));
        if ($t !== '') {
            return $t;
        }

        return '—';
    }

    /**
     * ຊື່ສຳລັບ dropdown ພາກສ່ວນຈ່າຍ (ຮູปแบบ ພາກສ່ວນກາງ / ພາກວິຊາ...)
     * ດຶງຈາກ DB ແລ້ວແປງຕາມ department_name / department_type.
     */
    public function expenseSectionLabel(): string
    {
        $name = trim((string) ($this->department_name ?? ''));
        $type = strtolower(trim((string) ($this->department_type ?? '')));
        $key = strtolower($name);

        $map = [
            'computer' => 'ພາກວິຊາຄອມພິວເຕີ',
            'com' => 'ພາກວິຊາຄອມພິວເຕີ',
            'central' => 'ສ່ວນກາງ',
            'center' => 'ສ່ວນກາງ',
            'ພາກສ່ວນກາງ' => 'ສ່ວນກາງ',
            'ສ່ວນກາງ' => 'ສ່ວນກາງ',
            'ກາງ' => 'ສ່ວນກາງ',
        ];

        if (isset($map[$key])) {
            return $map[$key];
        }

        if (isset($map[$type])) {
            return $map[$type];
        }

        if ($name === '') {
            return '—';
        }

        return $name;
    }

    public static function orderedForSelect()
    {
        return static::query()
            ->where('department_name', 'not like', '%ປະລິນ%')
            ->where('department_name', 'not like', '%ປະລິມ%')
            ->orderByRaw("CASE WHEN department_type = 'central' OR department_name IN ('ພາກສ່ວນກາງ', 'ສ່ວນກາງ') THEN 0 ELSE 1 END")
            ->orderBy('department_name')
            ->get();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function advanceRequests()
    {
        return $this->hasMany(\App\Models\AdvanceRequest::class, 'department_id');
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class, 'department_id');
    }
}
