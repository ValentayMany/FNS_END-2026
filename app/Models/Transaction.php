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
        'amount',
        'account_id',
        'department_id',
        'type',
        'category',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

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

    public function attachments()
    {
        return $this->hasMany(TransactionAttachment::class);
    }

    public function advanceRequest()
    {
        return $this->hasOne(AdvanceRequest::class, 'payment_transaction_id');
    }
}
