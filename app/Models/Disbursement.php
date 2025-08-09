<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    protected $fillable = [
        'disbursement_schedule_id',
        'paid_amount',
        'idempotency_key',
        'paid_date'
    ];

    public function schedule()
    {
        return $this->belongsTo(DisbursementSchedule::class, 'disbursement_schedule_id');
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }
}
