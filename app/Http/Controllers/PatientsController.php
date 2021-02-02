<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Context;
use PhpParser\Node\Expr\Array_;

class PatientsController extends Controller
{
    public function display(){
        $months_patients=array(0,0,0,-1,-1,-1,0,0,0,0,0,0);
        $percentages = array();
        $patients_graph = Patient::all();
        foreach ($patients_graph as $p){
            $date = $p->Date_of_identification;
            $month = (int)substr($date, 3, -5)-1;
            for ($i=0; $i<sizeof($months_patients); $i++){
                if ($i == $month){
                    $months_patients[$i]++;
                }
            }
        }

        for ($x=0; $x<11; $x++){
            if ($months_patients[$x]==0)
                $percentage = 0;
            else
                $percentage = ($months_patients[$x+1]-$months_patients[$x])/$months_patients[$x];
            $percentages[] = $percentage;
        }

        $patients = Patient::paginate(4);
        return view('patients', [
            'patients'=>$patients,
            'data'=>$percentages,
            'all_patients'=>$patients_graph
        ]);
    }
}
