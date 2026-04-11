<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'transaction_date',
        'description',
        'amount',
        'account_id',
        'department_id',
        'type',
        'category',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function attachments()
    {
        return $this->hasMany(TransactionAttachment::class);
    }

    public function advanceRequest()
    {
        return $this->hasOne(AdvanceRequest::class, 'payment_transaction_id');
    }
}
