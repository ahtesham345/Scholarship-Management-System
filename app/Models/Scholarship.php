<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'title',
        'description',
        'deadline'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function budgets()
    {
        return $this->hasMany(ScholarshipBudget::class);
    }
}
