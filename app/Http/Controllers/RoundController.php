<?php

namespace App\Http\Controllers;

use App\Models\PlacementChoice;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class RoundController extends Controller
{
    public function positions()
    {
        return view('placement_choice.position.index',compact('positions'));
    }
}
