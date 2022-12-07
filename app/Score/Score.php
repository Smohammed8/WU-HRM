<?php

namespace App\Score;

use App\Constants;
use App\Models\EducationComparisonCriteria;
use App\Models\Employee;
use App\Models\ExperienceComparisonCriteria;
use App\Models\ExternalExperience;
use App\Models\InternalExperience;
use App\Models\JobTitle;
use App\Models\PlacementChoice;
use App\Models\Position;
use App\Models\PositionRequirement;
use App\Models\PositionValue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Score
{

    public static function placeEmployee()
    {
        dd('placing employee');
    }
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
            sort($merge);
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
        // $employeeExperience = Carbon::now()->diff(Carbon::parse($placementChoice?->employee?->employement_date))->y;

        $employeeeFirstChoice = $placementChoice?->choiceOne;
        $employeeSecondChoice = $placementChoice?->choiceTwo;

        $choiceOneJobTitle = $employeeeFirstChoice?->jobTitle;
        $choiceTwoJobTitle = $employeeSecondChoice?->jobTitle;

        $employeeInternalExperience = $placementChoice->employee->internalExperiences->first();
        $employeeExternalExperience = $placementChoice->employee->externalExperiences->first();

        $internalExpChoiceOne = Score::calculateInternalExperience($employeeInternalExperience, $choiceOneJobTitle);
        $externalExpChoiceone = Score::calculateExternalExperience($employeeExternalExperience, $choiceOneJobTitle);

        $internalExpChoiceTwo = Score::calculateInternalExperience($employeeInternalExperience, $choiceTwoJobTitle);
        $externalExpChoiceTwo = Score::calculateExternalExperience($employeeExternalExperience, $choiceTwoJobTitle);

        $totalyearOne = Score::calculateTotalYear($internalExpChoiceOne, $externalExpChoiceone);
        $totalyearTwo = Score::calculateTotalYear($internalExpChoiceTwo, $externalExpChoiceTwo);

        $score = Score::getExpScore($choiceOneJobTitle, $totalyearOne);
        $scoreSecond = Score::getExpScore($choiceTwoJobTitle, $totalyearTwo);

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

    public static function calculateInternalExperience($internalExperience, $jobTitle)
    {
        $internalExp = 0;
        if ($internalExperience) {
            if ($internalExperience->jobTitle == $jobTitle) {
                $startDate = $internalExperience->start_date;
                if (!$internalExperience->end_date) {
                    $endDate = Carbon::now();
                }else{
                    $endDate = $internalExperience->end_date;
                }
                $internalExp = $endDate->diffInYears($startDate);
            }
        }
        return $internalExp;
    }

    public static function calculateExternalExperience($externalExperience, $jobTitle)
    {
        $externalExp = 0;
        if ($externalExperience) {
            if ($externalExperience->job_title == $jobTitle->name) {
                $startDate = $externalExperience->start_date;
                if (!$externalExperience->end_date) {
                    $endDate = Carbon::now();
                }else{
                    $endDate = $externalExperience->end_date;
                }
                $externalExp = $endDate->diffInYears($startDate);
            }
        }
        return $externalExp;
    }

    public static function calculateTotalYear($internalExp, $externalExp)
    {
        $totalyear = $internalExp + $externalExp;
        return $totalyear;
    }

    public static function getExpScore($jobTitle, $totalyear)
    {
        $score = 0;
        $positionType = $jobTitle?->positionType;

        $requirement = PositionRequirement::where('name', Constants::EXPERIENCE_CRITERIA)->first();

        $positionValue = PositionValue::where('position_type_id', $positionType?->id)->where('position_requirement_id', $requirement?->id)->first();

        $experienceCriterias = ExperienceComparisonCriteria::where('position_value_id', $positionValue?->id)->get();

        foreach ($experienceCriterias as $key => $experienceCriteria) {
            if (!$experienceCriteria->max_year) {
                $minYear = $experienceCriteria->min_year;
                if ($totalyear > $minYear) {
                    $score = $experienceCriteria->value;
                }
            } else {
                $minYear = $experienceCriteria->min_year;
                $maxYear = $experienceCriteria->max_year;

                if ($minYear < $totalyear && $totalyear < $maxYear) {
                    $score = $experienceCriteria->value;
                }
            }
        }

        return $score;
    }
}
