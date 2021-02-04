<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonorController extends Controller
{

    function payments()
    {
        $amount = DB::table("donors")
            ->select("amount_donated")
            ->where("created_at", 'like', '2000%')
            ->get();

        echo $amount[0]->amount_donated;
//        $time = Carbon::now()->format('m');
//        echo $time;
    }

    public function display()
    {
        $donors = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->get();

        //displaying the graph
        $donations = DB::Table('donations')
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
            ->get();

        $months_donations=array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($donations as $d){
            $date = $d->donation_month;
            $month = (int)substr($date, 3, -5)-1;
            $ammount = (int)$d->amount_donated;
            for ($i=0; $i<sizeof($months_donations); $i++){
                if ($i == $month){
                    $months_donations[$i]+=$ammount;
                }
            }
        }
        $month = DB::Table('months')
            ->select('id', 'month_name')
            ->get();

        return view('distribution', [
            'officers' => Officer::paginate(10),
            'all_officers' => Officer::all(),
            'months' => $month,
            'donors' => $donors,
            'data' => $months_donations,
        ]);
    }

    public function show($donor)
    {
        $donors = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->get();

        $selected_donor = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->where('donor_ID', '=', $donor)
            ->get();

        $donations = DB::Table('donations')
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
            ->where('donor_ID', '=', $donor)
            ->get();

        $months_donations = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($donations as $d) {
            $date = $d->donation_month;
            $month = (int)substr($date, 3, -5) - 1;
            $ammount = (int)$d->amount_donated;
            for ($i = 0; $i < sizeof($months_donations); $i++) {
                if ($i == $month) {
                    $months_donations[$i] += $ammount;
                }
            }
        }

        return view('donor', [
            'officers' => Officer::paginate(10),
            'donors' => $donors,
            'data' => $months_donations,
            'selected_donor' => $selected_donor,
        ]);
    }

    public function add(Request $request){
        $donation = new Donation;
        $donation->amount_donated = $request->ammount;
        $donation->donation_month = $request->date;

        $donors = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->get();

        foreach ($donors as $d){
            if ($d->donor_name == $request->donor){
                $donation->donor_ID = $d->donor_ID;
                break;
            }
        }

        $admins = DB::Table('users')
            ->select('id', 'name')
            ->get();

        foreach ($admins as $a){
            if ($a->id == 1){
                $donation->administrator_ID = $a->id;
            }
        }

        $donation->save();

        return view('distribution');
    }

}

