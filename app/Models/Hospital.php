<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    public function officers()
    {
        return $this->hasMany(Officer::class);
    }


    public function patients()
    {
        return $this->hasMany(Officer_patient::class);
    }

    public function administrator()
    {
        return $this->belongsTo(User::class);
    }
}
