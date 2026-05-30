<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'username',
        'full_name',
        'password',
        'role_id',
        'department_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ---- Relationships ----
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // ---- Role Helpers ----
    public function hasRole(string $roleName): bool
    {
        return $this->role?->role_name === $roleName;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isRequester(): bool
    {
        return $this->hasRole('requester');
    }

    public function isCashier(): bool
    {
        return $this->hasRole('cashier');
    }

    public function isRevenueOfficer(): bool
    {
        return $this->hasRole('revenue_officer');
    }

    public function isAccountant(): bool
    {
        return $this->hasRole('accountant');
    }

    public function isHeadOfFinance(): bool
    {
        return $this->hasRole('head_of_finance');
    }

    public function isDeputyHead(): bool
    {
        return $this->hasRole('deputy_head_of_faculty');
    }

    public function isFacultyHead(): bool
    {
        return $this->hasRole('head_of_faculty');
    }

    // ---- เพิ่ม 2 บรรทัดนี้ ----
    public function isTreasurer(): bool
    {
        return $this->hasRole('treasurer');
    }

    public function isTreasuryReconciliation(): bool
    {
        return $this->hasRole('treasury_reconciliation_officer');
    }

    public function isApprover(): bool
    {
        return in_array($this->role?->role_name, [
            'accountant',
            'head_of_finance',
            'deputy_head_of_faculty',
            'head_of_faculty',
        ]);
    }

    // ---- Aliases for Views ----
    public function canApprove(): bool
    {
        return $this->isApprover();
    }

    public function isFinanceHead(): bool
    {
        return $this->isHeadOfFinance();
    }

    public function isDeanOrDeputy(): bool
    {
        return $this->isDeputyHead() || $this->isFacultyHead();
    }

    public function roleDisplay(): string
    {
        $names = [
            'admin' => 'Admin (ຜູ້ດູແລລະບົບ)',
            'requester' => 'Requester (ຜູ້ຂໍອະນຸມັດ)',
            'accountant' => 'Accountant (ນາຍບັນຊີ)',
            'head_of_finance' => 'Finance Head (ຫົວໜ້າການເງິນ)',
            'deputy_head_of_faculty' => 'Deputy Dean (ຮອງຫົວໜ້າຄະນະ)',
            'head_of_faculty' => 'Dean (ຫົວໜ້າຄະນະ)',
            'cashier' => 'Cashier (ຈ່າຍເງິນ)',
            'revenue_officer' => 'Revenue Officer (ຮັບເງິນ)',
            'treasurer' => 'Treasurer (ຄັງເງິນ)',
            'treasury_reconciliation_officer' => 'Treasury Recon (ສະສາງຄັງ)',
        ];
        return $names[$this->role?->role_name] ?? ($this->role?->role_name ?? 'Unknown');
    }
}
