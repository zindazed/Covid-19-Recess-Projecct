<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    function addhospital(Request $req)
    {
        $hospital = new Hospital;

        //from the form
        $hospital->hospital_name = $req->hospital_name;
        $hospital->category = $req->category;
        $hospital->class = $req->class;
        $hospital->district = $req->district;
        $hospital->head_name = $req->head_name;
        $hospital->Email = $req->Email;
        $hospital->password = $req->password;

        //deriving position from hospital category
        switch ($req->class)
        {
            case "General":
                $hospital->officer_position = 'Head';
                break;
            case "Regional Referral":
                $hospital->officer_position = 'Superintendent';
                break;
            case "National Referral":
                $hospital->officer_position = 'Director';
                break;
        }

        $hospital->administrator_ID = Auth::user()->id;

        $message = $hospital->save();

        return view("hospital", [
            "message" => $message
        ]);
    }
}
