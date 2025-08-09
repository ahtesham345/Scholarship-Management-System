<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'scholarship_id',
        'status',
        'remarks'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function reviewLogs()
    {
        return $this->hasMany(ReviewLog::class);
    }

    public function award()
    {
        return $this->hasOne(ApplicationAward::class);
    }
}
