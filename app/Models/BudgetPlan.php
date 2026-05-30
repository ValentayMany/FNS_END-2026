<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'fiscal_year',
        'name',
        'total_budget',
    ];

    public function lineItems()
    {
        return $this->hasMany(BudgetLineItem::class, 'budget_plan_id');
    }
}
