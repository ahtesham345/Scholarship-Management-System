<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceLog extends Model
{
    protected $fillable = [
        'entity_type',
        'entity_id',
        'action',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];
}
