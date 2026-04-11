<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvanceClearingAttachment extends Model
{
    public $timestamps = false;

    protected $table = 'advance_clearing_attachments';

    protected $fillable = [
        'advance_request_id',
        'original_name',
        'stored_name',
        'mime_type',
        'file_size',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function advanceRequest()
    {
        return $this->belongsTo(AdvanceRequest::class);
    }

    public function getFileSizeForHumansAttribute(): string
    {
        $bytes = $this->file_size ?? 0;
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }
}
