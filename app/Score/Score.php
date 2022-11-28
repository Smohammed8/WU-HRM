<?php

namespace App\Score;

use App\Constants;
use App\Models\EducationComparisonCriteria;
use App\Models\Employee;
use App\Models\ExperienceComparisonCriteria;
use App\Models\PlacementChoice;
use App\Models\Position;
use App\Models\PositionRequirement;
use App\Models\PositionValue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Score
{

    public static function computeResult()
    {
        $palcementChoices = PlacementChoice::all();
        foreach ($palcementChoices as $palcementChoice) {
            Score::calculateChoiceResult($palcementChoice);
        }

    }

    public static function computeRank( )
    {
        Score::computeResult();
        $positions = Position::all();
        $res = [];
        foreach ($positions as $position) {
            $positionOnePlacementChoices = DB::table('placement_choices as pc')->where('choice_one_id', $position->id)->select('pc.id', 'pc.choice_one_result')->get();
            $positionTwoPlacementChoices = DB::table('placement_choices as pc')->where('choice_two_id', $position->id)->select('pc.id', 'pc.choice_two_result')->get();
            $merge = $positionOnePlacementChoices->merge($positionTwoPlacementChoices)->toArray();
            rsort($merge);
            foreach ($merge as $key => $value) {
                $placementChoice = PlacementChoice::find($value->id);
                if($placementChoice->choice_one_id == $position->id){
                    $placementChoice->update([
                        'choice_one_rank'=>$key+1,
                    ]);
                }else{
                    $placementChoice->update([
                        'choice_two_rank'=>$key+1,
                    ]);
                }
            }
        }
        dd('dfd');
        dump($position);

    }

    public static function calculateChoiceResult(PlacementChoice $placementChoice)
    {
        $choiceOne = $placementChoice->choiceOne;
        $choiceTwo = $placementChoice->choiceTwo;
        $choiceOneExpScore = Score::getExperinceScore($placementChoice)[0];
        $choiceTwoExpScore = Score::getExperinceScore($placementChoice)[1];
        $choiceOneEduScore = Score::getEducationScore($choiceOne, $placementChoice->employee);
        $choiceTwoEduScore = Score::getEducationScore($choiceTwo, $placementChoice->employee);
        $choiceOneResult = $choiceOneEduScore + $choiceOneExpScore;
        $choiceTwoResult = $choiceTwoEduScore + $choiceTwoExpScore;
        $placementChoice->update([
            'choice_one_result' => $choiceOneResult,
            'choice_two_result' => $choiceTwoResult,
        ]);
    }
    public static function getExperinceScore($placementChoice)
    {
        $score = 0;
        $scoreSecond = 0;
        $arrScores = [];
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
            } else {
                $minYear = $experienceCriteria->min_year;
                $maxYear = $experienceCriteria->max_year;

                if ($minYear < $employeeExperience && $employeeExperience < $maxYear) {
                    $score = $experienceCriteria->value;
                }
            }
        }

        $positionTypeSecond = $employeeeSecondChoice->jobTitle->positionType;

        $positionValueSecond = PositionValue::where('position_type_id', $positionTypeSecond->id)->where('position_requirement_id', $requirement->id)->first();

        $experienceSecondCriterias = ExperienceComparisonCriteria::where('position_value_id', $positionValueSecond->id)->get();

        foreach ($experienceSecondCriterias as $key => $experienceSecondCriteria) {
            if (!$experienceSecondCriteria->max_year) {
                $minYear = $experienceSecondCriteria->min_year;
                if ($employeeExperience > $minYear) {
                    $scoreSecond = $experienceSecondCriteria->value;
                }
            } else {
                $minYear = $experienceSecondCriteria->min_year;
                $maxYear = $experienceSecondCriteria->max_year;

                if ($minYear < $employeeExperience && $employeeExperience < $maxYear) {
                    $scoreSecond = $experienceSecondCriteria->value;
                }
            }
        }

        array_push($arrScores, $score);
        array_push($arrScores, $scoreSecond);

        return $arrScores;
    }

    public static function checkIfEducationLevel(Position $position)
    {
    }

    public static function  checkIfExperienceLevel(Position $position, Employee $employee)
    {
        $eligible = false;
        $posMinExp = $position->jobTitle->total_minimum_work_experience;
        $emploExp = Carbon::now()->diff(Carbon::parse($employee->employement_date))->y;

        if ($emploExp >= $posMinExp) {
            $eligible = true;
        }

        return $eligible;
    }
    public static function canApplyOnPosition(Position $position, Employee $employee)
    {
        if (Score::checkIfEducationLevel($position) && Score::checkIfExperienceLevel($position, $employee))
            return true;
        return false;
    }

    public static function getEducationScore(Position $position, Employee $employee)
    {
        if (!$position->available_for_placement) {
            return null;
        }
        $jobTitle = $position->jobTitle;
        $positionRequirement = PositionRequirement::where('name', Constants::EDUCATION_CRITERIA)->first();
        if ($positionRequirement == null)
            return null;
        $positionValue = PositionValue::where('position_type_id', $jobTitle->positionType->id)->where('position_requirement_id', $positionRequirement->id)->first();
        if ($positionValue == null)
            return null;
        //
        $educationComparisonCriteriaQuery = EducationComparisonCriteria::where('position_value_id', $positionValue->id)->where('educational_level_id', $employee->educationLevel->id);
        if ($educationComparisonCriteriaQuery->count() == 2) {
            $educationComparisonCriteria = $educationComparisonCriteriaQuery->where('min_educational_level_id', $jobTitle->educational_level_id)->first();
        } else {
            $educationComparisonCriteria = $educationComparisonCriteriaQuery->first();
        }
        return $educationComparisonCriteria->value;
    }
}
