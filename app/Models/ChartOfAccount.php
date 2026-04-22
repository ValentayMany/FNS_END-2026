<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'account_code', 'account_name', 'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    public function budgetLineItems()
    {
        return $this->hasMany(BudgetLineItem::class, 'account_id');
    }

    /**
     * ดึง ID ของตัวเอง + ลูกหลานทั้งหมด (recursive)
     * ใช้สำหรับ filter transactions ที่อยู่ภายใต้หมวดนี้
     */
    public static function descendantIds(int $parentId): array
    {
        $ids = [$parentId];
        $children = self::where('parent_id', $parentId)->pluck('id')->toArray();

        foreach ($children as $childId) {
            $ids = array_merge($ids, self::descendantIds($childId));
        }

        return $ids;
    }
}
