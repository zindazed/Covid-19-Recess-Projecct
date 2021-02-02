<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        //graph display of donations made by well wishers
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

        ///////////////graph display for donations made in a given month//////////////////
        //getting all donors

        $month_donations = array();//array to contain donations money for donor in a give month
        $month_donors = array();//array to contains donors in a give month
        foreach ($donations as $d){
            $date = $d->donation_month;
            $month = (int)substr($date, 3, -5)-1;
            if ($month == 5){
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

        return view('home',[
            'patients' => Patient::all(),
            'officers' => Officer::all(),
            'total' => $total_donations,
            'data' => $months_donations,
            'month_donations' => $month_donations,
            'month_donor' => $month_donors,
        ]);
    }
}
