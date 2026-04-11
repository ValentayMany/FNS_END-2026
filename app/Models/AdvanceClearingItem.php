<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvanceClearingItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'advance_request_id',
        'description',
        'amount',
        'account_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function advanceRequest()
    {
        return $this->belongsTo(AdvanceRequest::class);
    }
}
