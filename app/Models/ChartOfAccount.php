<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'account_code', 'account_name'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }
}
