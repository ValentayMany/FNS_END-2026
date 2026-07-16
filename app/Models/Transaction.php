<?php

namespace App\Models;

use App\Support\LaoText;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'transaction_date',
        'description',
        'item_name',
        'amount',
        'account_id',
        'department_id',
        'type',
        'category',
        'payment_code',
        'payment_method',
        'receipt_no',
        'student_id',
        'revenue_channel',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    protected static function booted()
    {
        static::created(function ($transaction) {
            if ($transaction->type === 'expense' && $transaction->department_id) {
                Department::where('id', $transaction->department_id)
                    ->decrement('budget_amount', $transaction->amount);
            }
        });

        static::deleted(function ($transaction) {
            if ($transaction->type === 'expense' && $transaction->department_id) {
                Department::where('id', $transaction->department_id)
                    ->increment('budget_amount', $transaction->amount);
            }
        });

        static::updated(function ($transaction) {
            $oldType = $transaction->getOriginal('type');
            $newType = $transaction->type;
            $oldDeptId = $transaction->getOriginal('department_id');
            $newDeptId = $transaction->department_id;
            $oldAmount = (float) $transaction->getOriginal('amount');
            $newAmount = (float) $transaction->amount;

            if ($oldType === 'expense' && $newType === 'expense') {
                if ($oldDeptId != $newDeptId) {
                    if ($oldDeptId) {
                        Department::where('id', $oldDeptId)->increment('budget_amount', $oldAmount);
                    }
                    if ($newDeptId) {
                        Department::where('id', $newDeptId)->decrement('budget_amount', $newAmount);
                    }
                } else {
                    $diff = $newAmount - $oldAmount;
                    if ($diff != 0 && $newDeptId) {
                        Department::where('id', $newDeptId)->decrement('budget_amount', $diff);
                    }
                }
            } elseif ($oldType !== 'expense' && $newType === 'expense') {
                if ($newDeptId) {
                    Department::where('id', $newDeptId)->decrement('budget_amount', $newAmount);
                }
            } elseif ($oldType === 'expense' && $newType !== 'expense') {
                if ($oldDeptId) {
                    Department::where('id', $oldDeptId)->increment('budget_amount', $oldAmount);
                }
            }
        });
    }

    /** Fix ລຽ້ງ-style mark order for display (DB may store wrong keyboard order). */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => LaoText::normalize($value),
        );
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function advanceRequest()
    {
        return $this->hasOne(AdvanceRequest::class, 'payment_transaction_id');
    }
}
