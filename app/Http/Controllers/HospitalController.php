<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HospitalController extends Controller
{

    function view()
    {
        $message = 0;
        return view("hospital", [
            "message" => $message
        ]);

    }

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

                $new_user = new User();
                $new_user->name = $req->head_name;
                $new_user->email = $req->Email;
                $new_user->password = Hash::make($req->password);
                $new_user->save();
                break;
        }

        $hospital->administrator_ID = Auth::user()->id;

        $message = $hospital->save();

        return view("hospital", [
            "message" => $message
        ]);
    }
}
