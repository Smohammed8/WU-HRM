<?php

namespace App\Http\Controllers;

use App\Models\PlacementChoice;
use App\Score\ExperienceScore;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function experienceScore()
    {
        $palcementChoices = PlacementChoice::all();
        foreach ($palcementChoices as $key => $palcementChoice) {
            $a = new ExperienceScore();
            $score = $a->getExperinceScore($palcementChoice);
        }
        // dd($score);
    }
}
