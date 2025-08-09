<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostCategory extends Model
{
     protected $fillable = [
        'name'
    ];

    public function budgets()
    {
        return $this->hasMany(ScholarshipBudget::class);
    }

    public function allocations()
    {
        return $this->hasMany(ApplicationAwardAllocation::class);
    }
}
