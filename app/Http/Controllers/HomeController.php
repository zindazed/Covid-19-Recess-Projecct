<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //calculating total funds
        $donations = DB::Table('donations')
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
            ->get();
        $total_donations = 0;
        foreach ($donations as $d){
            $total_donations = $total_donations + (int)$d->amount_donated;
        }

        $donations1 = DB::Table('donations')
            ->select('donor_ID');

        $donations = DB::table("used_donations")
            ->select('donor_ID')
            ->where("donation_month",'like',"%".Carbon::now()->format('Y'))
            ->union($donations1)
            ->get();

        $donor_ids = array();

        foreach ($donations as $donation){
            $donor_ids[] = $donation->donor_ID;
        }

        $all_donors = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->whereIn('donor_ID', $donor_ids)
            ->get();

        //////displaying the graph donation amde by well wishers graph////////////////
        $donations_for_donors = DB::Table('donations')
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID');

        $donations = DB::table("used_donations")
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
            ->where("donation_month",'like',"%".Carbon::now()->format('Y'))
            ->union($donations_for_donors)
            ->get();

        $months_donations = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($donations as $d) {
            $date = $d->donation_month;
            $month = Carbon::parse($date)->format("m") - 1;
            $ammount = (int)$d->amount_donated;
            for ($i = 0; $i < sizeof($months_donations); $i++) {
                if ($i == $month) {
                    $months_donations[$i] += $ammount;
                }
            }
        }

        /////graph for donations made in a given month////////
        $donations_for_donors = DB::Table('donations')
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID');

        $donations = DB::table("used_donations")
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
            ->where("donation_month",'like',"%".Carbon::now()->format('Y'))
            ->union($donations_for_donors)
            ->get();

        $month_donors = array();//array to contains donors in a give month
        foreach ($donations as $d){
            $month = Carbon::parse($d->donation_month)->monthName;
            if ($month == Carbon::now()->monthName){
                $donor = DB::Table('donors')
                    ->select('donor_ID', 'donor_name')
                    ->where('donor_ID', '=', $d->donor_ID)
                    ->first();

                if (!array_key_exists($donor->donor_name, $month_donors)){
                    $month_donors[$donor->donor_name] = $d->amount_donated;
                }else{
                    $month_donors[$donor->donor_name] = $month_donors[$donor->donor_name] + $d->amount_donated;
                }

            }

        }
        $keys = array();
        $values = array();
        foreach ($month_donors as $key=>$value){
            $keys[] = $key;
            $values[] = $value;
        }

        $month = DB::Table('months')
            ->select('id', 'month_name')
            ->get();

        ///////////patients graph//////////
        $months_patients=array(0,0,0,0,0,0,0,0,0,0,0,0,0);
        $percentages = array();
        $patients_graph = DB::table("patients")
            ->select("*")
            ->where("date_of_identification","like",Carbon::now()->format("Y")."%")
            ->get();

        //Patient::all();

        foreach ($patients_graph as $p){
            $date = $p->date_of_identification;
            $month = Carbon::parse($date)->format("m") - 1;
            for ($i=0; $i<sizeof($months_patients); $i++){
                if ($i == $month){
                    $months_patients[$i]++;
                }
            }
        }

        for ($x=0; $x<12; $x++){
            if ($months_patients[$x]==0)
                $percentage = 0;
            else
                $percentage = ($months_patients[$x+1]-$months_patients[$x])/$months_patients[$x];
            $percentages[] = $percentage;
        }


        return view('home',[
            'patients' => Patient::all(),
            'officers' => Officer::all(),
            'total' => $total_donations,
            'data' => $months_donations,
            'month_donor' => $keys,
            'month_donations' => $values,

            'data1'=>$percentages,
        ]);
    }
}
