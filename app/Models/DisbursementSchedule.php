<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisbursementSchedule extends Model
{
    protected $fillable = [
        'application_award_id',
        'cost_category_id',
        'scheduled_amount',
        'scheduled_date'
    ];

    public function award()
    {
        return $this->belongsTo(ApplicationAward::class);
    }

    public function costCategory()
    {
        return $this->belongsTo(CostCategory::class);
    }

    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }
}
