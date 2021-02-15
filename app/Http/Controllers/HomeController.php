<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Models\Officer;
use App\Models\Patient;
use App\Models\PromotedOfficer;
use App\Models\WaitingList;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
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

        DB::table("promoted_officers")
            ->whereDate("created_at","<=",Carbon::now()->subMonth())
            ->delete();

        $this->promotion();
        $this->waiting();

        $promoted = DB::table("promoted_officers")
            ->select("*")
            ->paginate(5,["*"],"promotion")->fragment("promote");

        $waiting = DB::table("waiting_lists")
            ->select("*")
            ->paginate(5,["*"],"waiting")->fragment("wait");

        return view('home',[
            'patients' => Patient::all(),
            'officers' => Officer::all(),
            'total' => $total_donations,
            'data' => $months_donations,
            'month_donor' => $keys,
            'month_donations' => $values,

            'data1'=>$percentages,
            'waiting'=>$waiting,
            'promoted'=>$promoted,
        ]);
    }

    public function promotion()
    {
        $officers = DB::table("officers")
            ->select("*")
            ->get();

        foreach ($officers as $officer) {
            $patients = DB::table("officer_patients")
                ->select("patient_ID")
                ->where("officer_ID", "=", "$officer->officer_ID")
                ->get();
            $num = count($patients);
            $position = $officer->officer_position;

            if ($num >= 3 && $position == "Health Officer") {
                DB::table("officers")
                    ->where("officer_ID", "=", "$officer->officer_ID")
                    ->update(["officer_position" => "Senior health Officer"]);

                $promoted = new PromotedOfficer();
                $promoted->officer_ID = $officer->officer_ID;
                $promoted->officer_name = $officer->officer_name;
                $promoted->officer_position = "Senior health Officer";

                $hospital = DB::Table('hospitals')
                    ->select('hospital_name')
                    ->where("head_ID", "=", "$officer->head_ID")
                    ->first();

                $promoted->previous_hospital = $hospital->hospital_name;

                $head = DB::Table('hospitals')
                    ->select('head_ID','hospital_name')
                    ->where("class", "=", "Regional Referral")
                    ->get();

                $least = 100;
                $hospital = 0;
                foreach ($head as $h) {
                    $headed = DB::Table('officers')
                        ->select('officer_ID')
                        ->where("head_ID", "=", $h->head_ID)
                        ->get();
                    $num = count($headed);
                    if ($num < $least) {
                        $least = $num;
                        $hospital = $h;
                    }
                }

                $promoted->new_hospital = $hospital->hospital_name;
                try {
                    $promoted->save();
                }catch (QueryException $ex)
                {
                    DB::table("promoted_officers")
                        ->where("officer_ID","=","$officer->officer_ID")
                        ->update(["officer_position"=>"$promoted->officer_position",
                            "previous_hospital"=>$promoted->previous_hospital,
                            "new_hospital"=>$promoted->new_hospital
                        ]);
                }

                $officer->head_ID = $hospital->head_ID;
                DB::Table('officers')
                    ->where("officer_ID", "=", "$officer->officer_ID")
                    ->update(["head_ID" => "$hospital->head_ID"]);

            }
            if ($num >= 5 && $position == "Senior health Officer") {
                $officer->officer_position="Consultant";
                $consultant = new Consultant();

                $consultant->officer_ID = $officer->officer_ID;
                $consultant->officer_name = $officer->officer_name;
                $consultant->password = $officer->password;
                $consultant->officer_position = $officer->officer_position;
                $consultant->head_ID = $officer->head_ID;
                $consultant->administrator_ID = $officer->administrator_ID;
                $consultant->save();

                DB::table("officers")
                    ->where("officer_ID", "=", "$officer->officer_ID")
                    ->update(["officer_position" => $officer->officer_position]);

                $waiter = new WaitingList();

                $waiter->officer_ID = $officer->officer_ID;
                $waiter->officer_name = $officer->officer_name;
                $waiter->password = $officer->password;
                $waiter->officer_position = $officer->officer_position;
                $waiter->head_ID = $officer->head_ID;
                $waiter->administrator_ID = $officer->administrator_ID;
                $waiter->save();
            }

            $then = Carbon::parse($officer->updated_at)->format("Y");
            $now = Carbon::now()->format("Y");
            $nationals =  DB::table('hospitals')->select("head_ID")
                ->where("class","=","National Referral")
                ->get();
            foreach ($nationals as $national)
                if (($now - $then >= 5) && ($officer->head_ID == $national->head_ID)) {
                    DB::Table('officers')
                        ->where("officer_ID", "=", "$officer->officer_ID")
                        ->update(["Retired" => true]);

                    $promoted = new PromotedOfficer();
                    $promoted->officer_ID = $officer->officer_ID;
                    $promoted->officer_name = $officer->officer_name;
                    $promoted->officer_position = "Retired";

                    $hospital = DB::Table('hospitals')
                        ->select('hospital_name')
                        ->where("head_ID", "=", "$officer->head_ID")
                        ->first();

                    $promoted->previous_hospital = $hospital->hospital_name;
                    $promoted->new_hospital = "None";
                    try {
                        $promoted->save();
                    }catch (QueryException $ex)
                    {
                        DB::table("promoted_officers")
                            ->where("officer_ID","=","$officer->officer_ID")
                            ->update(["officer_position"=>"$promoted->officer_position",
                            "previous_hospital"=>$promoted->previous_hospital,
                            "new_hospital"=>$promoted->new_hospital
                            ]);
                    }
                }
        }
    }

    public function waiting()
    {
        $waiters = DB::Table('waiting_lists')
            ->select('*')
            ->get();

        if ($waiters)
            foreach ($waiters as $waiter)
            {
                $officer = DB::table("officers")
                    ->select("*")
                    ->where("officer_ID", "=", "$waiter->officer_ID")
                    ->first();

                $promoted = new PromotedOfficer();
                $promoted->officer_ID = $officer->officer_ID;
                $promoted->officer_name = $officer->officer_name;
                $promoted->officer_position = "Consultant";

                $hospital = DB::Table('hospitals')
                    ->select('hospital_name')
                    ->where("head_ID", "=", "$officer->head_ID")
                    ->first();

                $promoted->previous_hospital = $hospital->hospital_name;

                $head = DB::Table('hospitals')
                    ->select('head_ID','hospital_name')
                    ->where("class", "=", "National Referral")
                    ->get();

                $least = 4;
                $hospital = 0;
                $full = true;
                foreach ($head as $h) {
                    $headed = DB::Table('officers')
                        ->select('officer_ID')
                        ->where("head_ID", "=", $h->head_ID)
                        ->where("Retired", "=", "0")
                        ->get();
                    $num = count($headed);
                    if ($num < $least) {
                        $least = $num;
                        $hospital = $h;
                        $full = false;
                    }
                }

                if($full)
                    break;
                else
                {
                    $promoted->new_hospital = $hospital->hospital_name;
                    try {
                        $promoted->save();
                    }catch (QueryException $ex)
                    {
                        DB::table("promoted_officers")
                            ->where("officer_ID","=","$officer->officer_ID")
                            ->update(["officer_position"=>"$promoted->officer_position",
                                "previous_hospital"=>$promoted->previous_hospital,
                                "new_hospital"=>$promoted->new_hospital
                            ]);
                    }

                    $officer->head_ID = $hospital->head_ID;
                    DB::table('officers')
                        ->where("officer_ID", "=", "$officer->officer_ID")
                        ->update(["head_ID" => "$hospital->head_ID","updated_at"=>Carbon::now()]);

                    DB::table("waiting_lists")
                        ->where("officer_ID", "=", "$waiter->officer_ID")
                        ->delete();
                }
            }
    }

}
