<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    public $timestamps = false;

    protected $fillable = ['department_name', 'department_type'];

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
            'central' => 'ພາກສ່ວນກາງ',
            'center' => 'ພາກສ່ວນກາງ',
            'ພາກສ່ວນກາງ' => 'ພາກສ່ວນກາງ',
            'ສ່ວນກາງ' => 'ພາກສ່ວນກາງ',
            'ກາງ' => 'ພາກສ່ວນກາງ',
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

        if (preg_match('/[\x{0E80}-\x{0EFF}]/u', $name)) {
            if (str_starts_with($name, 'ພາກສ່ວນ') || str_starts_with($name, 'ພາກວິຊາ')) {
                return $name;
            }

            return 'ພາກສ່ວນ'.$name;
        }

        return 'ພາກວິຊາ '.$name;
    }

    public static function orderedForSelect()
    {
        return static::query()
            ->orderByRaw("CASE WHEN department_type = 'central' OR department_name IN ('ພາກສ່ວນກາງ', 'ສ່ວນກາງ') THEN 0 ELSE 1 END")
            ->orderBy('department_name')
            ->get();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
