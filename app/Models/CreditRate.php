<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditRate extends Model
{
    protected $table = 'creditrate';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'YEARLEVEL',
        'COURSEID',
        'CREDITRATE',
    ];

    /**
     * หลักสูตรที่เกี่ยวข้อง
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'COURSEID', 'COURSEID');
    }
}
