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
        $placementChoices = PlacementChoice::all();
        $positions = Position::all();
        foreach ($positions as $key => $position) {
            $quota = $position->position_available_for_placement;
            $counter = 0;
            $positionOnePlacementChoices = DB::table('placement_choices as pc')->where('choice_one_id', $position->id)->select('pc.id', 'pc.choice_one_rank as rank')->get();
            $positionTwoPlacementChoices = DB::table('placement_choices as pc')->where('choice_two_id', $position->id)->select('pc.id', 'pc.choice_two_rank as rank')->get();
            $merge = $positionOnePlacementChoices->merge($positionTwoPlacementChoices)->sortBy('rank')->toArray();
            $x = [];
            foreach ($positionTwoPlacementChoices as $checkPos) {
                if (PlacementChoice::find($checkPos->id)->choice_one_rank <= PlacementChoice::find($checkPos->id)->choiceOne->position_available_for_placement) {
                    array_push($x, PlacementChoice::find($checkPos->id)->id);
                }
            }
            foreach ($merge as $item) {
                if ($counter >= $quota) {
                    break;
                }
                if (!in_array($item->id, $x)) {
                    $counter++;
                    PlacementChoice::find($item->id)->update([
                        'new_position' => $position->id
                    ]);
                }
            }
        }
    }
    public static function computeResult()
    {
        Score::switchUserChoiceBasedOnLevel();
        $palcementChoices = PlacementChoice::all();
        foreach ($palcementChoices as $palcementChoice) {
            Score::calculateChoiceResult($palcementChoice);
        }
        // dd('asd');
    }

    public static function switchUserChoiceBasedOnLevel()
    {
        $placementChoices = PlacementChoice::all();
        foreach($placementChoices as $placementChoice){
            $choiceOneLevel = $placementChoice->choiceOne->jobTitle->level;
            $choiceTwoLevel = $placementChoice->choiceTwo->jobTitle->level;
            if(array_key_exists($choiceOneLevel->name,Constants::JOB_LEVELS)){
                if(array_key_exists($choiceTwoLevel->name,Constants::JOB_LEVELS)){
                    if(Constants::JOB_LEVELS[$choiceOneLevel->name]<Constants::JOB_LEVELS[$choiceTwoLevel->name] && $placementChoice->is_placement_choice_switched != true ){
                        $placementChoice->update([
                            'choice_one_id' => $placementChoice->choice_two_id,
                            'choice_two_id' => $placementChoice->choice_one_id,
                            'is_placement_choice_switched' => true
                        ]);
                    }
                }else{
                    return abort(505,'Unable to find job level of '.$choiceTwoLevel->name);
                }
            }else{
                return abort(505,'Unable to find job level of '.$choiceOneLevel->name);
            }
        }
    }

    public static function computeRank()
    {
        Score::computeResult();
        $positions = Position::all();
        $res = [];
        foreach ($positions as $position) {
            $positionOnePlacementChoices = DB::table('placement_choices as pc')->where('choice_one_id', $position->id)->select('pc.id', 'pc.choice_one_result as result')->get();
            $positionTwoPlacementChoices = DB::table('placement_choices as pc')->where('choice_two_id', $position->id)->select('pc.id', 'pc.choice_two_result as result')->get();
            $merge = $positionOnePlacementChoices->merge($positionTwoPlacementChoices)->sortBy('result')->toArray();
            sort($merge);
            foreach ($merge as $key => $value) {
                $placementChoice = PlacementChoice::find($value->id);
                if ($placementChoice->choice_one_id == $position->id) {
                    $placementChoice->update([
                        'choice_one_rank' => $key + 1,
                    ]);
                } else {
                    $placementChoice->update([
                        'choice_two_rank' => $key + 1,
                    ]);
                }
            }
        }
        // dd('asas');
    }


    public static function calculateChoiceResult(PlacementChoice $placementChoice)
    {
        $choiceOne = $placementChoice->choiceOne;
        $choiceTwo = $placementChoice->choiceTwo;
       
        $choiceOneExpScore = Score::getExperinceScore($placementChoice)[0];
        $choiceTwoExpScore = Score::getExperinceScore($placementChoice)[1];
        // if ($placementChoice->employee->id == 10) {
        //     dd($choiceOneExpScore, $choiceTwoExpScore);
        // }

         $result1 = Score::eligiblityCheck($choiceOne,$placementChoice->employee);
         $result2 = Score::eligiblityCheck($choiceTwo,$placementChoice->employee);

         if($result1 ==false){ // not eligible employee
         $choiceOneEduScore = 0;
         $efficiencyScore  =0;
         }
         else{
         $choiceOneEduScore = Score::getEducationScore($choiceOne, $placementChoice->employee);
         $efficiencyScore   = Score::getEvaluationScore($placementChoice->employee);
         }
         if($result2 ==false){
         $choiceTwoEduScore = 0;
         $efficiencyScore  =0;
         }
         else{
         $choiceTwoEduScore = Score::getEducationScore($choiceTwo, $placementChoice->employee);
         $efficiencyScore   = Score::getEvaluationScore($placementChoice->employee);
         }

        $choiceOneResult = $choiceOneEduScore + $choiceOneExpScore + $efficiencyScore;
        $choiceTwoResult = $choiceTwoEduScore + $choiceTwoExpScore + $efficiencyScore;
        $placementChoice->update([
            'choice_one_result' => $choiceOneResult,
            'choice_two_result' => $choiceTwoResult,
        ]);
    }
        
    public static function eligiblityCheck(Position $position,Employee $employee){
        $employee_feild  = $employee->fieldOfStudy->id;
        if(!in_array($employee_feild,$position->jobTitle->JobTitleCategory->fieldOfStudies()->pluck('id')->toArray()) ) {
            // if($employee->id == 10){
            //     dd($employee->fieldOfStudy,$position->jobTitle->JobTitleCategory->fieldOfStudies);
            // }
            return false;
        }
        return true;
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

        $employeeInternalExperiences = $placementChoice->employee->internalExperiences;
        $employeeExternalExperiences = $placementChoice->employee->externalExperiences;

        $internalExpChoiceOne = Score::calculateInternalExperience($employeeInternalExperiences, $choiceOneJobTitle);
        $externalExpChoiceone = Score::calculateExternalExperience($employeeExternalExperiences, $choiceOneJobTitle);

        $internalExpChoiceTwo = Score::calculateInternalExperience($employeeInternalExperiences, $choiceTwoJobTitle);
        $externalExpChoiceTwo = Score::calculateExternalExperience($employeeExternalExperiences, $choiceTwoJobTitle);
        $totalyearOne = Score::calculateTotalYear($internalExpChoiceOne, $externalExpChoiceone);
        $totalyearTwo = Score::calculateTotalYear($internalExpChoiceTwo, $externalExpChoiceTwo);
        // if ($placementChoice->employee->id ==10) {
        //     dump($totalyearOne);
        // }

        $score = Score::getExpScore($choiceOneJobTitle, $totalyearOne);
        $scoreSecond = Score::getExpScore($choiceTwoJobTitle, $totalyearTwo);

        // $score = $scoreSecond = $placementChoice->employee->getTotalInternalExperience()->format('%y');

        array_push($arrScores, intval($score));
        array_push($arrScores, intval($scoreSecond));
        // dump($placementChoice->employee->name);
        // dd($arrScores);
        return $arrScores;
    }

    public static function checkIfEducationLevel(Position $position)
    {

    }

    public static function  checkIfExperienceLevel(Position $position, Employee $employee)
    {
        $eligible = false;
        $posMinExp = $position->jobTitle?->total_minimum_work_experience;
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
        $educationComparisonCriteriaQuery = EducationComparisonCriteria::where('position_value_id', $positionValue->id)->where('educational_level_id', $employee->educationLevel->id);
        if ($educationComparisonCriteriaQuery->count() >= 2) {
            $educationComparisonCriteria = $educationComparisonCriteriaQuery->where('min_educational_level_id', $jobTitle->educational_level_id)->first();
        } else {
            $educationComparisonCriteria = $educationComparisonCriteriaQuery->first();
        }
      if($educationComparisonCriteria == null){
            // dd($positionValue);
            return 0;
            abort(403, 'Please enter correct educational criteria for education level  '.$employee->educationLevel->name.' on '.$position->name.' employee ' .$employee->name );
        }
        return $educationComparisonCriteria->value;
    }

    public static function calculateInternalExperience($internalExperiences, $jobTitle)
    {
        $internalExp = 0;
        foreach ($internalExperiences as $key => $internalExperience) {
            if ($internalExperience->canRelateToJobTitlte($jobTitle)) {
                $startDate = $internalExperience->start_date;
                if (!$internalExperience->end_date) {
                    $endDate = Carbon::now();
                } else {
                    $endDate = $internalExperience->end_date;
                }
                $internalExp += $endDate->diffInYears($startDate);
            }
            foreach ($jobTitle->jobTitlePrequests as $key => $pre) {
                if ($pre->jobTitlePrereuest->id == $internalExperience->jobTitle->id) {
                    $startDate = $internalExperience->start_date;
                    if (!$internalExperience->end_date) {
                        $endDate = Carbon::now();
                    } else {
                        $endDate = $internalExperience->end_date;
                    }
                    $internalExp += $endDate->diffInYears($startDate);
                }
            }
        }
        return $internalExp;
    }

    public static function calculateExternalExperience($externalExperiences, $jobTitle)
    {
        $externalExp = 0;
        foreach ($externalExperiences as $key => $externalExperience) {
            if ($externalExperience->canRelateToJobTitlte($jobTitle)) {
                $startDate = $externalExperience->start_date;
                if (!$externalExperience->end_date) {
                    $endDate = Carbon::now();
                } else {
                    $endDate = $externalExperience->end_date;
                }
                $externalExp += $endDate->diffInYears($startDate);
            }
            foreach ($jobTitle->jobTitlePrequests as $key => $pre) {
                if ($pre->jobTitlePrereuest->id == $externalExperience->jobTitle->id) {
                    $startDate = $externalExperience->start_date;
                    if (!$externalExperience->end_date) {
                        $endDate = Carbon::now();
                    } else {
                        $endDate = $externalExperience->end_date;
                    }
                    $externalExp += $endDate->diffInYears($startDate);
                }
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

    public static function getEvaluationScore(Employee $employee)
    {
        if (!$employee) {
            abort(403, 'employee not found');
        }
        if ($employee->evaluations->count() < 0) {
            abort(403, $employee->first_name.' '.$employee->father_name.' '.$employee->grand_father_name.' doesn\'t have evaluation score');
        }
        $evalution = $employee->evaluations->where('quarter_id',1)->first();
        $employeePosType = $employee->position?->jobTitle?->positionType;
        $requirement = PositionRequirement::where('name', Constants::EFFICIENCY_CRITERIA)->first();
        if (!$requirement) {
            abort(403, 'no such requirement');
        }
        $positionValue = PositionValue::where('position_type_id', $employeePosType->id)->where('position_requirement_id', $requirement->id)->first();

        $effScore = $positionValue->value * $evalution->total_mark / 100;
        return $effScore;
    }
}
