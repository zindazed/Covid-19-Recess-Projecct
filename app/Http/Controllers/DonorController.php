<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\Officer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function payments()
    {
        echo 'zed';
        //computing salary
//        $hospital->monthly_payment = 10000;
//
//        DB::table("donors")
//            -> select("amount_donated")
//            -> where("donation_month",'=','')
        return view('distribution');
    }

    public function display()
    {
        $all_donors = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->get();

        //////displaying the graph donation amde by well wishers graph////////////////
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

        /////graph for donations made in a given month////////
        $month_donations = array();//array to contain donations money for donor in a give month
        $month_donors = array();//array to contains donors in a give month
        foreach ($donations as $d){
            $date = $d->donation_month;
            $month = (int)substr($date, 3, -5);
            if ($month == 7){
                $donors = DB::Table('donors')
                    ->select('donor_ID', 'donor_name')
                    ->where('donor_ID', '=', $d->donor_ID)
                    ->get();
                foreach ($donors as $do){
                    $month_donors[] = $do->donor_name;
                }
                $month_donations[] = $d->amount_donated;
            }
        }
        $month = DB::Table('months')
            ->select('id', 'month_name')
            ->get();

        return view('distribution', [
            'officers' => Officer::paginate(10),
            'all_officers' => Officer::all(),
            'months' => $month,
            'donors' => $all_donors,
            'data' => $months_donations,
            'selected_donor' => '',
            'selected_month' => '',

            'month_donations' => $month_donations,
            'month_donor' => $month_donors,
        ]);
    }

    public function show($id)
    {
        ///////for displaying donations for a selected donor/////////////
        $all_donors = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->get();

        $selected_donor = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->where('donor_ID', '=', $id)
            ->get();

        $donations_for_donors = DB::Table('donations')
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
            ->where('donor_ID', '=', $id)
            ->get();

        $months_donations = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($donations_for_donors as $d) {
            $date = $d->donation_month;
            $month = (int)substr($date, 3, -5) - 1;
            $ammount = (int)$d->amount_donated;
            for ($i = 0; $i < sizeof($months_donations); $i++) {
                if ($i == $month) {
                    $months_donations[$i] += $ammount;
                }
            }
        }

        /////graph for donations of a selected month////////
        $donations = DB::Table('donations')
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
            ->get();
        $month_donations = array();//array to contain donations money for donor in a give month
        $month_donors = array();//array to contains donors in a give month
        foreach ($donations as $d){
            $date = $d->donation_month;
            $month = (int)substr($date, 3, -5);

            if ($month == $id){
                $donors = DB::Table('donors')
                    ->select('donor_ID', 'donor_name')
                    ->where('donor_ID', '=', $d->donor_ID)
                    ->get();
                foreach ($donors as $do){
                    $month_donors[] = $do->donor_name;
                }
                $month_donations[] = $d->amount_donated;
            }
        }

        $months = DB::Table('months')
            ->select('id', 'month_name')
            ->get();

        /////get selected month/////
        $selected_month = DB::Table('months')
            ->select('id', 'month_name')
            ->where('id', '=', $id)
            ->get();


        return view('distribution', [
            'officers' => Officer::paginate(10),
            'all_officers' => Officer::all(),
            'donors' => $all_donors,
            'data' => $months_donations,
            'selected_donor' => $selected_donor,
            'selected_month' => $selected_month,
            'months' => $months,

            'month_donations' => $month_donations,
            'month_donor' => $month_donors,
        ]);
    }

    public function add(Request $request){

        $donor = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->where('donor_name', '=', $request->donor)
            ->get();

//        foreach ($donor as $do){
//            if ($do->donor_name == $request->donor){
//                $donation = new Donation;
//                $donation->amount_donated = $request->ammount;
//                $donation->donation_month = $request->date;
//                $donation->donor_ID = $do->donor_ID;
//                $donation->administrator_ID = Auth::user()->id;
//
//
//                $donation->save();
//            }else{
//                $new_donor = new Donor;
//                $new_donor->donor_name = $request->donor;
//                $new_donor->administrator_ID = Auth::user()->id;
//                $new_donor->save();
//
//                $newly_entered_donor = DB::Table('donors')
//                    ->select('donor_ID', 'donor_name')
//                    ->where('donor_name', '=', $request->donor)
//                    ->get();
//
//                $new_donation = new Donation;
//                $new_donation->amount_donated = $request->ammount;
//                $new_donation->donation_month = $request->date;
//
//                foreach ($newly_entered_donor as $d){
//                    $new_donation->donor_ID = $d->donor_ID;
//                }
//                $new_donation->save();
//            }
//        }

        if ($donor->isNotEmpty()){
            foreach ($donor as $d){
                $donation = new Donation;
                $donation->amount_donated = $request->ammount;
                $donation->donation_month = $request->date;
                $donation->donor_ID = $d->donor_ID;
                $donation->administrator_ID = Auth::user()->id;


                $donation->save();
            }
        }
        else{
            $new_donor = new Donor;

            $new_donor->donor_name = $request->donor;
            $new_donor->administrator_ID = Auth::user()->id;


            $new_donor->save();

            $newly_entered_donor = DB::Table('donors')
                ->select('donor_ID', 'donor_name')
                ->where('donor_name', '=', $request->donor)
                ->get();

            $new_donation = new Donation;
            $new_donation->amount_donated = $request->ammount;
            $new_donation->donation_month = $request->date;

            foreach ($newly_entered_donor as $d){
                $new_donation->donor_ID = $d->donor_ID;
            }
            $new_donation->administrator_ID = Auth::user()->id;
            $new_donation->save();
        }

//        foreach ($donors as $d){
//            if ($d->donor_name == $request->donor){
//                $donation->donor_ID = $d->donor_ID;
//                break;
//            }
//        }
//
//        $admins = DB::Table('users')
//            ->select('id', 'name')
//            ->get();
//
//        foreach ($admins as $a){
//            if ($a->id == Auth::user()->id){
//                $donation->administrator_ID = $a->id;
//            }
//        }

        $months = DB::Table('months')
            ->select('id', 'month_name')
            ->get();

        $all_donors = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->get();

        //////displaying the graph donation amde by well wishers graph////////////////
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

        /////graph for donations made in a given month////////
        $month_donations = array();//array to contain donations money for donor in a give month
        $month_donors = array();//array to contains donors in a give month
        foreach ($donations as $d){
            $date = $d->donation_month;
            $month = (int)substr($date, 3, -5);
            if ($month == 8){
                $donors = DB::Table('donors')
                    ->select('donor_ID', 'donor_name')
                    ->where('donor_ID', '=', $d->donor_ID)
                    ->get();
                foreach ($donors as $do){
                    $month_donors[] = $do->donor_name;
                }
                $month_donations[] = $d->amount_donated;
            }
        }

        return view('distribution', [
            'officers' => Officer::paginate(10),
            'all_officers' => Officer::paginate(10),
            'months' => $months,
            'donors' => $all_donors,
            'selected_donor' => '',
            'selected_month' => '',
            'data' => $months_donations,

            'month_donations' => $month_donations,
            'month_donor' => $month_donors,
            ]);
    }

}

