<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationAward extends Model
{
    protected $fillable = [
        'application_id',
        'total_amount'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function allocations()
    {
        return $this->hasMany(ApplicationAwardAllocation::class);
    }

    public function schedules()
    {
        return $this->hasMany(DisbursementSchedule::class);
    }
}
