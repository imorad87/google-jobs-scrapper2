<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleJob extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scrapingJob()
    {
        return $this->belongsTo(ScrapingJob::class);
    }

    public function scrapingError()
    {
        return $this->hasOne(ScrapingError::class);
    }

    public function applyLinks()
    {
        return $this->hasMany(ApplyLink::class);
    }
}