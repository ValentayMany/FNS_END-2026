<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetLineItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'budget_plan_id',
        'account_id',
        'allocated_amount',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
    ];

    public function budgetPlan()
    {
        return $this->belongsTo(BudgetPlan::class);
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }
}
