<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;
    public function officers()
    {
        return $this->hasMany(Officer::class);
    }

    public function head()
    {
        return $this->belongsTo(Officer::class);
    }

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function hospitals()
    {
        return $this->hasOne(Hospital::class);
    }

    public function patients()
    {
        return $this->hasMany(Officer_patient::class);
    }

}
