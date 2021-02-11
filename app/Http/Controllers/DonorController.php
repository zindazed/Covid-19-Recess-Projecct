<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\Officer;
use App\Models\RetiredOfficer;
use App\Models\Salary;
use App\Models\Consultant;
use App\Models\UsedDonation;
use App\Models\WaitingList;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Array_;

class DonorController extends Controller
{
    function payments()
    {
        try
        {

            $amount = DB::table("donations")
                ->select(DB::raw("SUM(amount_donated) as salary"))
                ->get();
            $total = $amount[0]->salary;
            if (!$total) {
                $total = 0;
            }

            $time = Carbon::now()->subMonth()->format('Y-m');
            $last = DB::table("salaries")
                ->select("saved")
                ->where("Date", "=", "$time")
                ->first();

            if ($last)
                $total = $total + $last->saved;

            //first subtract that of paid promoted consultants
            //will be implemented after promotion is done
            $consultants = $this->promotion();
            $total = $total - (10 * count($consultants));

            $pos_num = array();
            $postion1 = array("Head", "Superintendent", "Director");
            foreach ($postion1 as $position) {
                $ids = DB::table("hospitals")
                    ->select("head_ID")
                    ->where("officer_position", "=", "$position")
                    ->get();
                $pos_num["$position"] = count($ids);
            }

            $postion2 = array("Health Officer", "Senior health Officer", "Consultant");
            foreach ($postion2 as $position) {
                $ids = DB::table("officers")
                    ->select("officer_ID")
                    ->where("officer_position", "=", "$position")
                    ->where("Retired", "=", "0")
                    ->get();
                $pos_num["$position"] = count($ids);
            }

            $ids = DB::table("users")
                ->select("id")
                ->where("position", "=", "Administrator")
                ->get();
            $pos_num["admin"] = count($ids);

            $salary = new Salary();

            if ($total <= 100) {
                $saved = $total;
                $director = 0;
                $superintendent = 0;
                $administrator = 0;
                $officer = 0;
                $senior_officer = 0;
                $head = 0;
            } else {
                $saved = 100;
                $director = 5;
                $superintendent = ($director / 2);
                $administrator = ((3 / 4) * $superintendent);
                $officer = ((8 / 5) * $administrator);
                $senior_officer = ($officer + (6 / 100) * $officer);
                $head = ($officer + (3.5 / 100) * $officer);

                $excess = $total - ($saved +
                        ($director * $pos_num["Director"]) +
                        ($superintendent * $pos_num["Superintendent"]) +
                        ($administrator * $pos_num["admin"]) +
                        ($officer * $pos_num["Health Officer"]) +
                        ($senior_officer * ($pos_num["Consultant"] + $pos_num["Senior health Officer"])) +
                        ($head * $pos_num["Head"])
                    );
                if ($excess < 0) {
                    $saved = $total;
                    $director = 0;
                    $superintendent = 0;
                    $administrator = 0;
                    $officer = 0;
                    $senior_officer = 0;
                    $head = 0;
                } else {
                    while (1) {
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

                        if ($more_excess <= 1) {
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
            $salary->Paid_Consultants = count($consultants);
            $salary->Head = $head;
            $salary->saved = $saved;


            if ($salary->save()) {
                DB::table("consultants")->delete();

                foreach ($consultants as $officer)
                {
                    $consultant = new Consultant();

                    $consultant->officer_ID = $officer->officer_ID;
                    $consultant->officer_name = $officer->officer_name;
                    $consultant->password = $officer->password;
                    $consultant->officer_position = $officer->officer_position;
                    $consultant->head_ID = $officer->head_ID;
                    $consultant->administrator_ID = $officer->administrator_ID;
                    $consultant->save();
                }

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
                    $used->save();
                }

                DB::table("donations")->delete();

                $officers = DB::table("officers")
                    ->select("officer_name", "officer_position", "officer_ID")
                    ->where("Retired", "=", "0");

                $heads = DB::table("hospitals")
                    ->select("head_name", "officer_position", "head_ID");

                $workers = DB::table("users")
                    ->select("name", "position", "id")
                    ->union($heads)
                    ->union($officers)
                    ->paginate(10);

                $salary = DB::table("salaries")
                    ->select("*")
                    ->where("Date", "=", "$time")
                    ->first();

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

                $consultant = DB::table("consultants")
                    ->select("*")
                    ->get();

                $this->waiting();

                $n_donor = false;
                $n_donation = false;

                return view('distribution', [
                    'new_donor'=> $n_donor,
                    'new_donation'=>$n_donation,
                    'officers' => $workers,
                    'salary' => $salary,
                    'all_officers' => Officer::all(),
                    'months' => $month,
                    'donors' => $all_donors,
                    'data' => $months_donations,
                    'consultants' => $consultant,
                    'selected_donor' => '',
                    'selected_month' => '',
                    'month_donor' => $keys,
                    'month_donations' => $values,
                ]);
            }
        } catch (QueryException $ex) {
            $time = Carbon::now()->format('Y-m');
            $officers = DB::table("officers")
                ->select("officer_name", "officer_position", "officer_ID")
                ->where("Retired", "=", "0");

            $heads = DB::table("hospitals")
                ->select("head_name", "officer_position", "head_ID");

            $workers = DB::table("users")
                ->select("name", "position", "id")
                ->union($heads)
                ->union($officers)
                ->paginate(10);

            $salary = DB::table("salaries")
                ->select("*")
                ->where("Date", "=", "$time")
                ->first();

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

            $consultant = DB::table("consultants")
                ->select("*")
                ->get();

            $n_donor = false;
            $n_donation = false;

            return view('distribution', [
                'new_donor'=> $n_donor,
                'new_donation'=>$n_donation,
                'officers' => $workers,
                'salary' => $salary,
                'all_officers' => Officer::all(),
                'months' => $month,
                'donors' => $all_donors,
                'data' => $months_donations,
                'consultants' => $consultant,
                'selected_donor' => '',
                'selected_month' => '',
                'month_donor' => $keys,
                'month_donations' => $values,
            ]);
        }
    }

    public function promotion()
    {
        $officers = DB::table("officers")
            ->select("*")
            ->get();

        $counter = 0;
        $consultants = array();
        foreach ($officers as $officer) {
            $patients = DB::table("officer_patients")
                ->select("patient_ID")
                ->where("officer_ID", "=", "$officer->officer_ID")
                ->get();
            $num = count($patients);
            $position = $officer->officer_position;

            if ($num >= 4 && $position == "Health Officer") {
                DB::table("officers")
                    ->where("officer_ID", "=", "$officer->officer_ID")
                    ->update(["officer_position" => "Senior health Officer"]);

                $head = DB::Table('hospitals')
                    ->select('head_ID')
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
                        $hospital = $h->head_ID;
                    }
                }

                $officer->head_ID = $hospital;
                DB::Table('officers')
                    ->where("officer_ID", "=", "$officer->officer_ID")
                    ->update(["head_ID" => "$hospital"]);

            }
            if ($num >= 8 && $position == "Senior health Officer") {
                $officer->officer_position="Consultant";
                $consultants[$counter] = $officer;
                $counter++;
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

            $then = Carbon::parse($officer->updated_at)->format("i");
            $now = Carbon::now()->format("i");
            $nationals =  DB::table('hospitals')->select("head_ID")
                ->where("class","=","National Referral")
                ->get();
            foreach ($nationals as $national)
                if (($now - $then >= 1) && ($officer->head_ID == $national->head_ID)) {
                    DB::Table('officers')
                        ->where("officer_ID", "=", "$officer->officer_ID")
                        ->update(["Retired" => true]);
                }
        }
        return $consultants;
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

                $head = DB::Table('hospitals')
                ->select('head_ID')
                ->where("class", "=", "National Referral")
                ->get();

                $least = 200;
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
                        $hospital = $h->head_ID;
                        $full = false;
                    }
                }

                if($full)
                    break;
                else
                {
                    $officer->head_ID = $hospital;
                    DB::table('officers')
                        ->where("officer_ID", "=", "$officer->officer_ID")
                        ->update(["head_ID" => "$hospital","updated_at"=>Carbon::now()]);

                    DB::table("waiting_lists")
                        ->where("officer_ID", "=", "$waiter->officer_ID")
                        ->delete();
                }
            }
    }

    public function display()
    {
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

        $time = Carbon::now()->format('Y-m');

        $officers = DB::table("officers")
            ->select("officer_name", "officer_position", "officer_ID")
            ->where("Retired", "=", "0");

        $heads = DB::table("hospitals")
            ->select("head_name", "officer_position", "head_ID");

        $workers = DB::table("users")
            ->select("name", "position", "id")
            ->union($heads)
            ->union($officers)
            ->paginate(10);

        $salary = DB::table("salaries")
            ->select("*")
            ->where("Date", "=", "$time")
            ->first();

        $consultants = DB::table("consultants")
            ->select("*")
            ->get();

        $n_donor = false;
        $n_donation = false;

        return view('distribution', [
            'new_donor'=> $n_donor,
            'new_donation'=>$n_donation,
            'officers' => $workers,
            'all_officers' => Officer::all(),
            'months' => $month,
            'donors' => $all_donors,
            'data' => $months_donations,
            'selected_donor' => '',
            'selected_month' => '',
            'month_donor' => $keys,
            'month_donations' => $values,
            'salary' => $salary,
            'consultants' => $consultants,
        ]);
    }

    public function show($id)
    {
        ///////for displaying donations for a selected donor/////////////
        if (is_numeric($id)) {
            $nid = $id;
            DB::table("ids")
                ->update(["number"=>$nid]);

            $a_id = DB::table("ids")
                ->select("*")
                ->first();
            $mid = $a_id->month;
        }
        else
        {
            $mid = $id;
            DB::table("ids")
                ->update(["month"=>$mid]);

            $a_id = DB::table("ids")
                ->select("*")
                ->first();
            $nid = $a_id->number;
        }
        if ($nid == -1)
        {
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

            $selected_donor = null;

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
        }
        else {
            $donations1 = DB::Table('donations')
                ->select('donor_ID');

            $donations = DB::table("used_donations")
                ->select('donor_ID')
                ->where("donation_month", 'like', "%" . Carbon::now()->format('Y'))
                ->union($donations1)
                ->get();
            $donor_ids = array();
            foreach ($donations as $donation) {
                $donor_ids[] = $donation->donor_ID;
            }


            $all_donors = DB::Table('donors')
                ->select('donor_ID', 'donor_name')
                ->whereIn('donor_ID', $donor_ids)
                ->get();

            $selected_donor = DB::Table('donors')
                ->select('donor_ID', 'donor_name')
                ->where('donor_ID', '=', $nid)
                ->get();

            $donations = DB::Table('donations')
                ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
                ->where('donor_ID', '=', $nid);

            $donations_for_donors = DB::table("used_donations")
                ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
                ->where("donation_month", 'like', "%" . Carbon::now()->format('Y'))
                ->where('donor_ID', '=', $nid)
                ->union($donations)
                ->get();

            $months_donations = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            foreach ($donations_for_donors as $d) {
                $date = $d->donation_month;
                $month = Carbon::parse($date)->format("m") - 1;
                $ammount = (int)$d->amount_donated;
                for ($i = 0; $i < sizeof($months_donations); $i++) {
                    if ($i == $month) {
                        $months_donations[$i] += $ammount;
                    }
                }
            }
        }

        /////graph for donations of a selected month////////
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
            if ($month == $mid){
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

        $months = DB::Table('months')
            ->select('id', 'month_name')
            ->get();

        /////get selected month/////
        $selected_month = DB::Table('months')
            ->select('id', 'month_name')
            ->where('month_name', '=', $mid)
            ->get();

        $time = Carbon::now()->format('Y-m');

        $officers = DB::table("officers")
            ->select("officer_name", "officer_position", "officer_ID")
            ->where("Retired", "=", "0");

        $heads = DB::table("hospitals")
            ->select("head_name", "officer_position", "head_ID");

        $workers = DB::table("users")
            ->select("name", "position", "id")
            ->union($heads)
            ->union($officers)
            ->paginate(10);

        $salary = DB::table("salaries")
            ->select("*")
            ->where("Date", "=", "$time")
            ->first();

        $consultant = DB::table("consultants")
            ->select("*")
            ->get();

        $n_donor = false;
        $n_donation = false;

        return view('distribution', [
            'new_donor'=> $n_donor,
            'new_donation'=>$n_donation,
            'officers' => $workers,
            'salary' => $salary,
            'all_officers' => Officer::all(),
            'donors' => $all_donors,
            'data' => $months_donations,
            'selected_donor' => $selected_donor,
            'selected_month' => $selected_month,
            'months' => $months,
            'consultants' => $consultant,
            'month_donor' => $keys,
            'month_donations' => $values
        ]);
    }

    public function add(Request $request){
        $donor = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->where('donor_name', '=', $request->donor)
            ->get();

        if ($donor->isNotEmpty()){
            foreach ($donor as $d){
                $donation = new Donation;
                $donation->amount_donated = $request->ammount;
                $donation->donation_month = Carbon::now()->format('d-m-Y');
                $donation->donor_ID = $d->donor_ID;
                $donation->administrator_ID = Auth::user()->id;


                $n_donation = $donation->save();
            }
                $n_donor = false;
        }
        else{
            $new_donor = new Donor;

            $new_donor->donor_name = $request->donor;
            $new_donor->administrator_ID = Auth::user()->id;


            $n_donor = $new_donor->save();

            $newly_entered_donor = DB::Table('donors')
                ->select('donor_ID', 'donor_name')
                ->where('donor_name', '=', $request->donor)
                ->get();

            $new_donation = new Donation;
            $new_donation->amount_donated = $request->ammount;
            $new_donation->donation_month = Carbon::now()->format('d-m-Y');

            foreach ($newly_entered_donor as $d){
                $new_donation->donor_ID = $d->donor_ID;
            }
            $new_donation->administrator_ID = Auth::user()->id;
            $n_donation = $new_donation->save();
        }

        $time = Carbon::now()->format('Y-m');
        $officers = DB::table("officers")
            ->select("officer_name", "officer_position", "officer_ID")
            ->where("Retired", "=", "0");

        $heads = DB::table("hospitals")
            ->select("head_name", "officer_position", "head_ID");

        $workers = DB::table("users")
            ->select("name", "position", "id")
            ->union($heads)
            ->union($officers)
            ->paginate(10);

        $salary = DB::table("salaries")
            ->select("*")
            ->where("Date", "=", "$time")
            ->first();

        $all_donors = DB::Table('donors')
            ->select('donor_ID', 'donor_name')
            ->get();

        //////displaying the graph donation amde by well wishers graph////////////////
        $donations = DB::Table('donations')
            ->select('donation_ID', 'donation_month', 'amount_donated', 'donor_ID')
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

        $consultant = DB::table("consultants")
            ->select("*")
            ->get();

        return view('distribution', [
            'officers' => $workers,
            'salary' => $salary,
            'all_officers' => Officer::all(),
            'months' => $month,
            'donors' => $all_donors,
            'data' => $months_donations,
            'consultants' => $consultant,
            'selected_donor' => '',
            'selected_month' => '',
            'month_donor' => $keys,
            'month_donations' => $values,
            'new_donor'=> $n_donor,
            'new_donation'=>$n_donation,

            ]);
    }

}

