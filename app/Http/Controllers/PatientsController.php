<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Context;
use PhpParser\Node\Expr\Array_;

class PatientsController extends Controller
{
    public function display(){
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

        $patients = Patient::paginate(4);

        $positive_cases = DB::Table('patients')
            ->select('patient_name', 'case_type')
            ->where('case_type', '=', 'positive')
            ->get();

        $False_positive_cases = DB::Table('patients')
            ->select('patient_name', 'case_type')
            ->where('case_type', '=', 'false positive')
            ->get();

        $Asymptomatic = DB::Table('patients')
            ->select('patient_name', 'case_type')
            ->where('category', '=', 'Asymptomatic')
            ->get();

        $Symptomatics = DB::Table('patients')
            ->select('patient_name', 'case_type')
            ->where('category', '=', 'Symptomatic')
            ->get();



        return view('patients', [
            'Symptomatics' => $Symptomatics,
            'Asymptomatic' => $Asymptomatic,
            'positive_cases' => $positive_cases,
            'False_positive_cases' => $False_positive_cases,
            'patients_all' => Patient::all(),
            'patients'=>$patients,
            'data'=>$percentages,
            'all_patients'=>$patients_graph
        ]);
    }
}
