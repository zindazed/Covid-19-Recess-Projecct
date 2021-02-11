<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfficerController extends Controller
{
    function view()
    {
        $message = 0;
        return view("officer", [
            "message" => $message
        ]);

    }

    function addofficer(Request $req)
    {
        $officer = new Officer;

        //from the form
        $officer->officer_name = $req->officer_name;
        $officer->password = $req->password;

        $officer->Retired = false;
        $officer->officer_position = "Officer";

        $head = DB::Table('hospitals')
            ->select('head_ID')
            ->where("class","=","General")
            ->get();

        $least = 15;
        $full= true;
        $hospital = 0;
        foreach ($head as $h)
        {
            $headed = DB::Table('officers')
                ->select('officer_ID')
                ->where("head_ID", "=", $h->head_ID)
                ->get();
            $num = count($headed);
            if ( $num < $least)
            {
                $least = $num;
                $hospital = $h->head_ID;
                $full = false;
            }
        }

        $officer->head_ID = $hospital;
        $officer->administrator_ID = Auth::user()->id;

        if (!$full)
        {
            $message = $officer->save();
        }
        else
        {
            $message = 2;
        }


        return view("officer", [
            "message" => $message
        ]);
    }
}
