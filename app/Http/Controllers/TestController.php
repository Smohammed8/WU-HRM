<?php

namespace App\Http\Controllers;

use App\Score\ExperienceScore;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function experienceScore()
    {
        $a = new ExperienceScore();
        $score = $a->getExperinceScore();
        dd($score);
    }
}
