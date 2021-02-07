<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\Patient;
use Database\Seeders\Hospital;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HierachyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display()
    {
//        $id = 319;
        $directors = DB::Table('hospitals')
            ->select('head_name', 'head_ID', 'District')
            ->where('officer_position', '=', 'Director')
            ->where('class', '=', 'National Referral')
            ->get();

        $sups = DB::Table('hospitals')
            ->select('head_name', 'head_ID', 'District')
            ->where('officer_position', '=', 'superintendent')
            ->where('class', '=', 'Regional Referral')
            ->get();

        $g_heads = DB::Table('hospitals')
            ->select('head_name', 'head_ID', 'District')
            ->where('officer_position', '=', 'Head')
            ->where('class', '=', 'General')
            ->get();

        return view('hierachy', [
            'directors' => $directors,
            'supretendants' => $sups,
            'general_heads' => $g_heads,
        ]);
    }
}
