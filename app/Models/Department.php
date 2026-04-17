<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    public $timestamps = false;

    protected $fillable = ['department_name', 'department_type'];

    /**
     * ຊື່ພາກສ່ວນຕາມຖານຂໍ້ມູນ (department_name) ສຳລັບ dropdown / ຕາຕະລາງ — ບໍ່ແປເປັນລາວ.
     * ຖ້າບໍ່ມີຊື່ ຈະໃຊ້ department_type ຖ້າມີ.
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

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
