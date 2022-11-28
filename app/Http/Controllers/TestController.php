<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PlacementChoice;
use App\Models\Position;
use App\Score\ExperienceScore;
use App\Score\Score;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function experienceScore()
    {
        $a = new Score();
        $psotions = Position::all();
        foreach ($psotions as $key => $position) {
            $employee = Employee::all()[1];
            $eligibility = $a->checkIfExperienceLevel($position, $employee);

            dd($eligibility);
        }
        // $palcementChoices = PlacementChoice::all();
        // foreach ($palcementChoices as $key => $palcementChoice) {
        //     $a = new ExperienceScore();
        //     $score = $a->getExperinceScore($palcementChoice);
        // }
        // dd($score);
    }
}
