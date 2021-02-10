<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedDonation extends Model
{
    use HasFactory;
    use HasFactory;
    protected $guarded = [];
    protected $table = 'used_donations';
    public $timestamps = false;
}
