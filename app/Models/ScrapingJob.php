<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Imtigger\LaravelJobStatus\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScrapingJob extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function googleJobs()
    {
        return $this->hasMany(GoogleJob::class);
    }

    public function scrapingErrors()
    {
        return $this->hasMany(ScrapingError::class);
    }
}