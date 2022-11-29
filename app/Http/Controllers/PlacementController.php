<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Employee;
use App\Models\PlacementChoice;
use App\Models\PlacementRound;
use App\Models\Position;
use App\Score\ExperienceScore;
use App\Score\Score;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    public function computeScore(PlacementRound $placementRound)
    {
        Score::computeRank();
        $placementRound->update(['status'=>Constants::PLACEMENT_ROUND_STATUS_RANKED]);
        return redirect()->back()->with('message','Score computed successfully');
    }

    public function makePlacement(PlacementRound $placementRound)
    {
        $placementRound->update(['status'=>Constants::PLACEMENT_ROUND_STATUS_PLACED]);
        return redirect()->back();
    }
    
    public function approve(PlacementRound $placementRound)
    {
        $placementRound->update(['status'=>Constants::PLACEMENT_ROUND_STATUS_APPROVED]);
        return redirect()->back();
    }

    public function reset(PlacementRound $placementRound)
    {
        if($placementRound->status == Constants::PLACEMENT_ROUND_STATUS_OPENED ||$placementRound->status >= Constants::PLACEMENT_ROUND_STATUS_APPROVED ){
            return redirect()->back();
        }

        $placementRound->update([
            'status' => $placementRound->status -1,
        ]);
        return redirect()->back();
    }

    public function close(PlacementRound $placementRound)
    {
        $placementRound->update(['status'=>Constants::PLACEMENT_ROUND_STATUS_CLOSED]);
        return redirect()->back();
    }
}
