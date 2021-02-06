<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Officer;
use App\Models\Salary;
use App\Models\UsedDonation;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Array_;

class DonorController extends Controller
{

    function payments()
    {
        $amount = DB::table("donations")
            ->select(DB::raw("SUM(amount_donated) as salary"))
            ->get();
        $total = $amount[0]->salary;
        if(!$total)
        {
            $total = 0;
        }

        $time = Carbon::now()->subMonth()->format('Y-m');
        $last=DB::table("salaries")
            ->select("saved")
            ->where("Date","=","$time")
            ->first();

        if($last)
            $total = $total + $last->saved;

        //first subtract that of paid promoted consultants
        //will be implemented after promotion is done

        $pos_num = array();
        $postion1 = array("Head", "Superintendent", "Director");
        foreach ($postion1 as $position)
        {
            $ids = DB::table("hospitals")
                ->select("head_ID")
                ->where("officer_position","=","$position")
                ->get();
            $pos_num["$position"] = count($ids);
        }

        $postion2 = array("Health Officer", "Senior health Officer", "Consultant");
        foreach ($postion2 as $position)
        {
            $ids = DB::table("officers")
                ->select("officer_ID")
                ->where("officer_position","=","$position")
                ->get();
            $pos_num["$position"] = count($ids);
        }

        $ids = DB::table("users")
            ->select("id")
            ->where("position","=","Administrator")
            ->get();
        $pos_num["admin"] = count($ids);

        $salary = new Salary();

        if($total <= 100)
        {
            $saved = $total;
            $director = 0;
            $superintendent = 0;
            $administrator = 0;
            $officer = 0;
            $senior_officer = 0;
            $head = 0;
        }
        else
        {
            $saved = 100;
            $director = 5;
            $superintendent = ($director/2);
            $administrator = ((3/4)*$superintendent);
            $officer = ((8/5)*$administrator);
            $senior_officer = ($officer + (6/100)*$officer);
            $head = ($officer + (3.5/100)*$officer);

            $excess = $total-( $saved+
                    ($director* $pos_num["Director"])+
                    ($superintendent* $pos_num["Superintendent"])+
                    ($administrator* $pos_num["admin"])+
                    ($officer * $pos_num["Health Officer"])+
                    ($senior_officer* ($pos_num["Consultant"] + $pos_num["Senior health Officer"]))+
                    ($head* $pos_num["Head"])
                );
            if($excess < 0)
            {
                $saved = $total;
                $director = 0;
                $superintendent = 0;
                $administrator = 0;
                $officer = 0;
                $senior_officer = 0;
                $head = 0;
            }
            else
            {
                while(1)
                {
                    $director = $director + (5 / 100 * $excess);
                    $superintendent = $superintendent + ((5 / 100 * $excess) / 2);
                    $administrator = ((3 / 4) * $superintendent);
                    $officer = ((8 / 5) * $administrator);
                    $senior_officer = ($officer + (6 / 100) * $officer);
                    $head = ($officer + (3.5 / 100) * $officer);

                    $more_excess = $total - ($saved +
                            ($director * $pos_num["Director"]) +
                            ($superintendent * $pos_num["Superintendent"]) +
                            ($administrator * $pos_num["admin"]) +
                            ($officer * $pos_num["Health Officer"]) +
                            ($senior_officer * ($pos_num["Consultant"] + $pos_num["Senior health Officer"])) +
                            ($head * $pos_num["Head"])
                        );

                    if ($more_excess <= 1)
                    {
                        $director = $director - (5 / 100 * $excess);
                        $superintendent = $superintendent - ((5 / 100 * $excess) / 2);
                        $administrator = ((3 / 4) * $superintendent);
                        $officer = ((8 / 5) * $administrator);
                        $senior_officer = ($officer + (6 / 100) * $officer);
                        $head = ($officer + (3.5 / 100) * $officer);
                        $saved = $saved + $excess;
                        break;
                    } else {
                        $excess = $more_excess;
                    }
                }
            }
        }

        $time = Carbon::now()->format('Y-m');

        $salary->Date = $time;
        $salary->Director = $director;
        $salary->Superintendent = $superintendent;
        $salary->Administrator = $administrator;
        $salary->Officer = $officer;
        $salary->Senior_Officer = $senior_officer;
        $salary->Head = $head;
        $salary->saved = $saved;

        try
        {
            if ($salary->save()) {
                $donations = DB::table("donations")
                    ->select("*")
                    ->get();

                foreach ($donations as $donation) {
                    $used = new UsedDonation();


                    $used->donation_ID = $donation->donation_ID;
                    $used->donation_month = $donation->donation_month;
                    $used->amount_donated = $donation->amount_donated;
                    $used->donor_ID = $donation->donor_ID;
                    $used->administrator_ID = $donation->administrator_ID;
                    $used->created_at = $donation->created_at;
                    $used->updated_at = $donation->updated_at;
                    $used->save();
                }

                DB::table("donations")->delete();

                $officers=DB::table("officers")
                    ->select("officer_name","officer_position","officer_ID");

                $heads=DB::table("hospitals")
                    ->select("head_name","officer_position","head_ID");

                $workers=DB::table("users")
                    ->select("name", "position", "id")
                    ->union($heads)
                    ->union($officers)
                    ->paginate(10);

                $salary=DB::table("salaries")
                    ->select("*")
                    ->where("Date","=","$time")
                    ->first();

                return view('distribution', array_merge([
                    'officers' => $workers,
                    'salary' => $salary,
                ],$this->display()));
            }
        }
        catch (QueryException $ex)
        {
            $salary=DB::table("salaries")
                ->select("*")
                ->where("Date","=","$time")
                ->first();

            $officers=DB::table("officers")
                ->select("officer_name","officer_position","officer_ID");

            $heads=DB::table("hospitals")
                ->select("head_name","officer_position","head_ID");

            $workers=DB::table("users")
                ->select("name", "position", "id")
                ->union($heads)
                ->union($officers)
                ->paginate(10);

            return view('distribution', array_merge([
                'officers' => $workers,
                'salary' => $salary,
            ],$this->display()));
        }
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

        return([
            'all_officers' => Officer::all(),
            'months' => $month,
            'donors' => $donors,
            'data' => $months_donations,
            ]);
//        return view('distribution', [
//            'officers' => $workers,
//            'all_officers' => Officer::all(),
//            'months' => $month,
//            'donors' => $donors,
//            'data' => $months_donations,
//            'salary' => $salary,
//        ]);
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

