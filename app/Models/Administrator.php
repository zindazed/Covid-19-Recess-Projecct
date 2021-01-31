<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;
    public function officers()
    {
        return $this->hasMany(Officer::class);
    }

    public function heads()
    {
        return $this->hasMany(Officer::class);
    }

    public function donorMoney()
    {
        return $this->hasMany(Donor::class);
    }
}
