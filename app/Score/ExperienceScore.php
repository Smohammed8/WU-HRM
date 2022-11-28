<?php

namespace App\Score;

use App\Constants;
use App\Models\Employee;
use App\Models\ExperienceComparisonCriteria;
use App\Models\PlacementChoice;
use App\Models\Position;
use App\Models\PositionRequirement;
use App\Models\PositionValue;
use Carbon\Carbon;

class ExperienceScore{
    public function getExperinceScore($placementChoice)
    {
        $score = 0;
        $employeeExperience = Carbon::now()->diff(Carbon::parse($placementChoice->employee->employement_date))->y;

        $employeeeFirstChoice = $placementChoice->choiceOne;
        $employeeeSecondChoice = $placementChoice->choiceTwo;
        $positionType = $employeeeFirstChoice->jobTitle->positionType;
        $requirement = PositionRequirement::where('name', Constants::EXPERIENCE_CRITERIA)->first();
        
        $positionValue = PositionValue::where('position_type_id', $positionType->id)->where('position_requirement_id', $requirement->id)->first();
            
        $experienceCriterias = ExperienceComparisonCriteria::where('position_value_id', $positionValue->id)->get();

        foreach ($experienceCriterias as $key => $experienceCriteria) {
            if (!$experienceCriteria->max_year) {
                $minYear = $experienceCriteria->min_year;
                if ($employeeExperience > $minYear) {
                    $score = $experienceCriteria->value;
                }
            }
            else{
                $minYear = $experienceCriteria->min_year;
                $maxYear = $experienceCriteria->max_year;

                if ($minYear < $employeeExperience && $employeeExperience < $maxYear) {
                    $score = $experienceCriteria->value;
                }
            }
        }
        return $score;
    }
}