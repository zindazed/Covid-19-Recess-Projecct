<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer_patient extends Model
{
    use HasFactory;
    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
