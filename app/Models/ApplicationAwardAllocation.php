<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationAwardAllocation extends Model
{
    protected $fillable = [
        'application_award_id',
        'cost_category_id',
        'committed_amount'
    ];

    public function award()
    {
        return $this->belongsTo(ApplicationAward::class, 'application_award_id');
    }

    public function costCategory()
    {
        return $this->belongsTo(CostCategory::class);
    }
}
