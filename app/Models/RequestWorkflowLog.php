<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestWorkflowLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'request_id', 'user_id', 'action', 'timestamp', 'comments'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function advanceRequest()
    {
        return $this->belongsTo(AdvanceRequest::class, 'request_id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
