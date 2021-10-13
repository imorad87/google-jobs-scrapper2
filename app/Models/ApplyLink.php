<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyLink extends Model
{
    use HasFactory;

    public function googleJob(){
        return $this->belongsTo(GoogleJob::class);
    }
}