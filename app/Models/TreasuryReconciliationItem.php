<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreasuryReconciliationItem extends Model
{
    public $timestamps = false;

    protected $table = 'treasury_reconciliation_items';

    protected $fillable = [
        'transaction_id',
        'reconciliation_date',
        'user_id',
    ];

    protected $casts = [
        'reconciliation_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
