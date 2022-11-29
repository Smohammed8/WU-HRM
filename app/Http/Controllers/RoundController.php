<?php

namespace App\Http\Controllers;

use App\Models\PlacementChoice;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoundController extends Controller
{
    public function positions()
    {
        return view('placement_choice.position.index',compact('positions'));
    }
}
