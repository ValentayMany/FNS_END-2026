<?php

namespace Database\Seeders;

use App\Models\AdvanceRequest;
use App\Models\Department;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * ພາກສ່ວນມາດຕະຖານສຳລັບ dropdown — ເພີ່ມຊື່ລາວ ແລະ ລວມແຖວ Computer ເກົ່າ.
     */
    public function run(): void
    {
        Department::firstOrCreate(
            ['department_name' => 'ພາກສ່ວນກາງ'],
            ['department_type' => 'central']
        );

        $faculty = Department::firstOrCreate(
            ['department_name' => 'ພາກວິຊາຄອມພິວເຕີ'],
            ['department_type' => 'faculty']
        );

        $legacyComputer = Department::query()
            ->where('id', '!=', $faculty->id)
            ->where(function ($q) {
                $q->whereRaw('LOWER(department_name) = ?', ['computer'])
                    ->orWhere('department_type', 'Com');
            })
            ->first();

        if ($legacyComputer) {
            $this->reassignDepartmentReferences($legacyComputer->id, $faculty->id);
            $legacyComputer->delete();
        }
    }

    private function reassignDepartmentReferences(int $fromId, int $toId): void
    {
        User::where('department_id', $fromId)->update(['department_id' => $toId]);
        Transaction::where('department_id', $fromId)->update(['department_id' => $toId]);
        AdvanceRequest::where('department_id', $fromId)->update(['department_id' => $toId]);
    }
}
