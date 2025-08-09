<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'disbursement_id',
        'file_path',
        'status'
    ];

    public function disbursement()
    {
        return $this->belongsTo(Disbursement::class);
    }
}
