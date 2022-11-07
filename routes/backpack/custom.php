<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::crud('chair-man-type', 'ChairManTypeCrudController');
    Route::crud('educational-level', 'EducationalLevelCrudController');
    Route::crud('employee', 'EmployeeCrudController');
    Route::crud('{employee}/employee-address', 'EmployeeAddressCrudController');
    Route::crud('employee-category', 'EmployeeCategoryCrudController');
    Route::crud('{employee}/employee-certificate', 'EmployeeCertificateCrudController');
    Route::crud('{employee}/employee-contact', 'EmployeeContactCrudController');
    Route::crud('{employee}/employee-family', 'EmployeeFamilyCrudController');
    Route::crud('{employee}/employee-language', 'EmployeeLanguageCrudController');
    Route::crud('employee-title', 'EmployeeTitleCrudController');
    Route::crud('employment-status', 'EmploymentStatusCrudController');
    Route::crud('employment-type', 'EmploymentTypeCrudController');
    Route::crud('ethnicity', 'EthnicityCrudController');
    Route::crud('{employee}/external-experience', 'ExternalExperienceCrudController');
    Route::crud('family-relationship', 'FamilyRelationshipCrudController');
    Route::crud('field-of-study', 'FieldOfStudyCrudController');
    Route::crud('{employee}/internal-experience', 'InternalExperienceCrudController');
    Route::crud('job-title', 'JobTitleCrudController');
    Route::crud('job-title-category', 'JobTitleCategoryCrudController');
    Route::crud('language', 'LanguageCrudController');
    Route::crud('{employee}/license', 'LicenseCrudController');
    Route::crud('license-type', 'LicenseTypeCrudController');
    Route::crud('marital-status', 'MaritalStatusCrudController');
    Route::crud('nationality', 'NationalityCrudController');
    Route::crud('organization', 'OrganizationCrudController');
    Route::crud('pension', 'PensionCrudController');
    Route::crud('region', 'RegionCrudController');
    Route::crud('religion', 'ReligionCrudController');
    Route::crud('skill', 'SkillCrudController');
    Route::crud('skill-type', 'SkillTypeCrudController');
    Route::crud('{employee}/training-and-study', 'TrainingAndStudyCrudController');
    Route::crud('unit', 'UnitCrudController');
    Route::crud('upload-file', 'UploadFileCrudController');
    Route::crud('employee-address', 'EmployeeAddressCrudController');
    Route::crud('employee-certificate', 'EmployeeCertificateCrudController');
    Route::crud('employee-contact', 'EmployeeContactCrudController');
    Route::crud('employee-evaluation', 'EmployeeEvaluationCrudController');
    Route::crud('employee-family', 'EmployeeFamilyCrudController');
    Route::crud('employee-language', 'EmployeeLanguageCrudController');
    Route::crud('evaluation-category', 'EvaluationCategoryCrudController');
    Route::crud('evaluation-level', 'EvaluationLevelCrudController');
    Route::crud('evalution-creteria', 'EvalutionCreteriaCrudController');
    Route::crud('external-experience', 'ExternalExperienceCrudController');
    Route::crud('internal-experience', 'InternalExperienceCrudController');
    Route::crud('license', 'LicenseCrudController');
    Route::crud('training-and-study', 'TrainingAndStudyCrudController');
    Route::crud('demotion', 'DemotionCrudController');
    Route::crud('leave', 'LeaveCrudController');
    Route::crud('misconduct', 'MisconductCrudController');
    Route::crud('promotion', 'PromotionCrudController');
    Route::crud('type-of-leave', 'TypeOfLeaveCrudController');
    Route::crud('type-of-misconduct', 'TypeOfMisconductCrudController');
    Route::crud('evaluation', 'EvaluationCrudController');
    Route::crud('quarter', 'QuarterCrudController');
    Route::crud('evaluation-period', 'EvaluationPeriodCrudController');
    Route::crud('form-style', 'FormStyleCrudController');
    Route::crud('salary-increament', 'SalaryIncreamentCrudController');
// this should be the absolute last line of this file
    Route::crud('position', 'PositionCrudController');
    Route::crud('{position}/minimum-requirement', 'MinimumRequirementCrudController');
    Route::crud('{position}/{minimum_requirement}/related-work', 'RelatedWorkCrudController');
    Route::crud('job-grade', 'JobGradeCrudController');
    Route::crud('level', 'LevelCrudController');
    Route::crud('minimum-requirement', 'MinimumRequirementCrudController');
    Route::crud('related-work', 'RelatedWorkCrudController');
    Route::crud('salary-scale', 'SalaryScaleCrudController');
    Route::crud('template', 'TemplateCrudController');
    Route::crud('template-type', 'TemplateTypeCrudController');
    Route::get('charts/weekly-users', 'Charts\WeeklyUsersChartController@response')->name('charts.weekly-users.index');
});