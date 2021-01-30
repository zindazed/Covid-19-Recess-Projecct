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

    public function head()
    {
        return $this->belongsTo(Officer::class);
    }
}
