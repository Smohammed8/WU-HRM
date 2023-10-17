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
use Illuminate\Support\Facades\Route;

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
        Score::placeEmployee();
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
        // if($placementRound->status == Constants::PLACEMENT_ROUND_STATUS_)
        if($placementRound->status == Constants::PLACEMENT_ROUND_STATUS_OPENED ||$placementRound->status >= Constants::PLACEMENT_ROUND_STATUS_APPROVED ){
            return redirect()->back();
        }
        $placementRound->update([
            'status' => $placementRound->status -1,
        ]);

        foreach ($placementRound->placementChoices as $key => $placementChoice) {
            $placementChoice->update([
                'choice_one_rank'=>null,
                'choice_two_rank'=>null,
                'new_position'=>null
            ]);
        }
        return redirect()->back();
    }

    public function close(PlacementRound $placementRound)
    {
        $placementRound->update(['status'=>Constants::PLACEMENT_ROUND_STATUS_CLOSED]);
        return redirect()->back();
    }
}
