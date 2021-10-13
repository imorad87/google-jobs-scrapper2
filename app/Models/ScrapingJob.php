<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapingJob extends Model
{
    use HasFactory;

    public function googleJobs(){
        return $this->hasMany(GoogleJob::class);
    }

    public function scrapingErrors(){
        return $this->hasMany(ScrapingError::class);
    }
}
