<?php

namespace Database\Seeders;

use App\Constants;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::findOrCreate(Constants::USER_TYPE_EMPLOYEE);
        Role::findOrCreate(Constants::USER_TYPE_ADMIN);
        Role::findOrCreate(Constants:: USER_TYPE_TEAM_LEADER );
        Role::findOrCreate(Constants::USER_TYPE_COORDINATOR);
        Role::findOrCreate(Constants::USER_TYPE_DIRECTOR );
        Role::findOrCreate(Constants::USER_TYPE_ENCODER);
        Role::findOrCreate(Constants::USER_TYPE_HR_OFFICER);
        Role::findOrCreate(Constants::USER_TYPE_TOP_MANAGMENT);
        Role::findOrCreate(Constants::USER_TYPE_SUPER_ADMIN);

        // Permission for users
        Permission::findOrCreate('employee.home');
        // Permission for dashboard
        Permission::findOrCreate('dashboard.sidebar');
        Permission::findOrCreate('dashboard.content');
        // Permission for users
        Permission::findOrCreate('user.icrud');
        Permission::findOrCreate('user.index');
        Permission::findOrCreate('user.create');
        Permission::findOrCreate('user.show');
        Permission::findOrCreate('user.edit');
        Permission::findOrCreate('user.delete');
        // Permission for roles
        Permission::findOrCreate('role.icrud');
        Permission::findOrCreate('role.index');
        Permission::findOrCreate('role.create');
        Permission::findOrCreate('role.show');
        Permission::findOrCreate('role.edit');
        Permission::findOrCreate('role.delete');
        // Permission for permission
        Permission::findOrCreate('permission.icrud');
        Permission::findOrCreate('permission.index');
        Permission::findOrCreate('permission.create');
        Permission::findOrCreate('permission.show');
        Permission::findOrCreate('permission.edit');
        Permission::findOrCreate('permission.delete');
        // Permission for employee
        Permission::findOrCreate('employee.icrud');
        Permission::findOrCreate('employee.index');
        Permission::findOrCreate('employee.create');
        Permission::findOrCreate('employee.show');
        Permission::findOrCreate('employee.edit');
        Permission::findOrCreate('employee.delete');
        Permission::findOrCreate('employee-sample.export');
        Permission::findOrCreate('employee.import');
        /////////////////////////////////////////////////////
        Permission::findOrCreate('download.manual');
        //////////////////////////////////////////////////
        Permission::findOrCreate('error.logs.index');
        Permission::findOrCreate('retirment.employee.index');
        Permission::findOrCreate('probation.employee.index');
        Permission::findOrCreate('left.employee.index');
        Permission::findOrCreate('temporary.employee.index');
        Permission::findOrCreate('contract.employee.index');
        // Permission for setting
        Permission::findOrCreate('setting.icrud');
        Permission::findOrCreate('setting.index');
        Permission::findOrCreate('setting.create');
        Permission::findOrCreate('setting.show');
        Permission::findOrCreate('setting.edit');
        Permission::findOrCreate('setting.delete');
//////////////////////////////////////////////////////////////////////////////
        // Employee Emeregncy contact
        Permission::findOrCreate('employee.emergency-contact.icrud');
        Permission::findOrCreate('employee.emergency-contact.index');
        Permission::findOrCreate('employee.emergency-contact.create');
        Permission::findOrCreate('employee.emergency-contact.show');
        Permission::findOrCreate('employee.emergency-contact.edit');
        Permission::findOrCreate('employee.emergency-contact.delete');
        // Employee Education
        Permission::findOrCreate('employee.education.icrud');
        Permission::findOrCreate('employee.education.index');
        Permission::findOrCreate('employee.education.create');
        Permission::findOrCreate('employee.education.show');
        Permission::findOrCreate('employee.education.edit');
        Permission::findOrCreate('employee.education.delete');

        // Employee Internal Experince
        Permission::findOrCreate('employee.internal-experience.icrud');
        Permission::findOrCreate('employee.internal-experience.index');
        Permission::findOrCreate('employee.internal-experience.create');
        Permission::findOrCreate('employee.internal-experience.show');
        Permission::findOrCreate('employee.internal-experience.edit');
        Permission::findOrCreate('employee.internal-experience.delete');

        // Employee Internal Experince
        Permission::findOrCreate('employee.external-experience.icrud');
        Permission::findOrCreate('employee.external-experience.index');
        Permission::findOrCreate('employee.external-experience.create');
        Permission::findOrCreate('employee.external-experience.show');
        Permission::findOrCreate('employee.external-experience.edit');
        Permission::findOrCreate('employee.external-experience.delete');
        // Permission for employee operation efficency
        Permission::findOrCreate('employee.efficency.icrud');
        Permission::findOrCreate('employee.efficency.index');
        Permission::findOrCreate('employee.efficency.create');
        Permission::findOrCreate('employee.efficency.show');
        Permission::findOrCreate('employee.efficency.edit');
        Permission::findOrCreate('employee.efficency.delete');
        // Permission for employee families
        Permission::findOrCreate('employee.family.icrud');
        Permission::findOrCreate('employee.family.index');
        Permission::findOrCreate('employee.family.create');
        Permission::findOrCreate('employee.family.show');
        Permission::findOrCreate('employee.family.edit');
        Permission::findOrCreate('employee.family.delete');
        // Permission for employee families
        Permission::findOrCreate('employee.family.icrud');
        Permission::findOrCreate('employee.family.index');
        Permission::findOrCreate('employee.family.create');
        Permission::findOrCreate('employee.family.show');
        Permission::findOrCreate('employee.family.edit');
        Permission::findOrCreate('employee.family.delete');

        // Permission for employee  language ability
        Permission::findOrCreate('employee.language.icrud');
        Permission::findOrCreate('employee.language.index');
        Permission::findOrCreate('employee.language.create');
        Permission::findOrCreate('employee.language.show');
        Permission::findOrCreate('employee.language.edit');
        Permission::findOrCreate('employee.language.delete');
        // Permission for employee  training and study
        Permission::findOrCreate('employee.training-study.icrud');
        Permission::findOrCreate('employee.training-study.index');
        Permission::findOrCreate('employee.training-study.create');
        Permission::findOrCreate('employee.training-study.show');
        Permission::findOrCreate('employee.training-study.edit');
        Permission::findOrCreate('employee.training-study.delete');

        // Permission for employee  special-skill
        Permission::findOrCreate('employee.special-skill.icrud');
        Permission::findOrCreate('employee.special-skill.index');
        Permission::findOrCreate('employee.special-skill.create');
        Permission::findOrCreate('employee.special-skill.show');
        Permission::findOrCreate('employee.special-skill.edit');
        Permission::findOrCreate('employee.special-skill.delete');
    
        // Permission for employee  license
        Permission::findOrCreate('employee.license.icrud');
        Permission::findOrCreate('employee.license.index');
        Permission::findOrCreate('employee.license.create');
        Permission::findOrCreate('employee.license.show');
        Permission::findOrCreate('employee.license.edit');
        Permission::findOrCreate('employee.license.delete');
    
        // Permission for employee  certification
        Permission::findOrCreate('employee.certification.icrud');
        Permission::findOrCreate('employee.certification.index');
        Permission::findOrCreate('employee.certification.create');
        Permission::findOrCreate('employee.certification.show');
        Permission::findOrCreate('employee.certification.edit');
        Permission::findOrCreate('employee.certification.delete');
        // Permission for employee  letters
        Permission::findOrCreate('employee.letters.icrud');
        Permission::findOrCreate('employee.letters.index');
        Permission::findOrCreate('employee.letters.create');
        Permission::findOrCreate('employee.letters.show');
        Permission::findOrCreate('employee.letters.edit');
        Permission::findOrCreate('employee.letters.delete');
///////////////////////////////////////////////////////////////////////////
        // Permission for id
        Permission::findOrCreate('id.icrud');
        Permission::findOrCreate('id.index');
        Permission::findOrCreate('id.create');
        Permission::findOrCreate('id.show');
        Permission::findOrCreate('id.delete');
        Permission::findOrCreate('id.design.icrud');
        Permission::findOrCreate('id.design.index');
        Permission::findOrCreate('id.design.create');
        Permission::findOrCreate('id.design.show');
        Permission::findOrCreate('id.design.delete');
        // Permission for id setting
        Permission::findOrCreate('id.setting.icrud');
        Permission::findOrCreate('id.setting.index');
        Permission::findOrCreate('id.setting.create');
        Permission::findOrCreate('id.setting.edit');
        Permission::findOrCreate('id.setting.delete');
        // Permission for employee settings
        Permission::findOrCreate('employee.setting.icrud');
        Permission::findOrCreate('employee.setting.index');
        Permission::findOrCreate('employee.setting.create');
        Permission::findOrCreate('employee.setting.show');
        Permission::findOrCreate('employee.setting.edit');
        Permission::findOrCreate('employee.setting.delete');
        // Permission for employee id print
        Permission::findOrCreate('employee.id.print');
        Permission::findOrCreate('hire.letter.print');
        Permission::findOrCreate('experience.letter.print');
    
        // Permission for employee operation demotion
        Permission::findOrCreate('employee.demotion.icrud');
        Permission::findOrCreate('employee.demotion.index');
        Permission::findOrCreate('employee.demotion.create');
        Permission::findOrCreate('employee.demotion.show');
        Permission::findOrCreate('employee.demotion.edit');
        Permission::findOrCreate('employee.demotion.delete');
        // Permission for employee operation promotion
        Permission::findOrCreate('employee.promotion.icrud');
        Permission::findOrCreate('employee.promotion.index');
        Permission::findOrCreate('employee.promotion.create');
        Permission::findOrCreate('employee.promotion.show');
        Permission::findOrCreate('employee.promotion.edit');
        Permission::findOrCreate('employee.promotion.delete');

        // Permission for employee operation discipline
        Permission::findOrCreate('employee.discipline.icrud');
        Permission::findOrCreate('employee.discipline.index');
        Permission::findOrCreate('employee.discipline.create');
        Permission::findOrCreate('employee.discipline.show');
        Permission::findOrCreate('employee.discipline.edit');
        Permission::findOrCreate('employee.discipline.delete');

        // Permission for employee operation leave
        Permission::findOrCreate('employee.leave.icrud');
        Permission::findOrCreate('employee.leave.index');
        Permission::findOrCreate('employee.leave.create');
        Permission::findOrCreate('employee.leave.show');
        Permission::findOrCreate('employee.leave.edit');
        Permission::findOrCreate('employee.leave.delete');



        // Permission for organization
        Permission::findOrCreate('organization.icrud');
        Permission::findOrCreate('organization.index');
        Permission::findOrCreate('organization.create');
        Permission::findOrCreate('organization.show');
        Permission::findOrCreate('organization.edit');
        Permission::findOrCreate('organization.delete');
        Permission::findOrCreate('organization.structure.view');

        // Permission for unit
        Permission::findOrCreate('unit.icrud');
        Permission::findOrCreate('unit.index');
        Permission::findOrCreate('unit.create');
        Permission::findOrCreate('unit.show');
        Permission::findOrCreate('unit.edit');
        Permission::findOrCreate('unit.delete');
///////////////////////////////////////////////////////////////////////////////
        // Permission for field of study in G setting
        Permission::findOrCreate('field_of_study.icrud');
        Permission::findOrCreate('field_of_study.index');
        Permission::findOrCreate('field_of_study.create');
        Permission::findOrCreate('field_of_study.show');
        Permission::findOrCreate('field_of_study.edit');
        Permission::findOrCreate('field_of_study.delete');
      ////////////// 
        Permission::findOrCreate('employee_title.icrud');
        Permission::findOrCreate('employee_title.index');
        Permission::findOrCreate('employee_title.create');
        Permission::findOrCreate('employee_title.show');
        Permission::findOrCreate('employee_title.edit');
        Permission::findOrCreate('employee_title.delete');
        /////////////////// Permission for ethnicity in G setting
        Permission::findOrCreate('ethnicity.icrud');
        Permission::findOrCreate('ethnicity.index');
        Permission::findOrCreate('ethnicity.create');
        Permission::findOrCreate('ethnicity.show');
        Permission::findOrCreate('ethnicity.edit');
        Permission::findOrCreate('ethnicity.delete');

        /////////////////// Permission for category in G setting
        Permission::findOrCreate('employee_category.icrud');
        Permission::findOrCreate('employee_category.index');
        Permission::findOrCreate('employee_category.create');
        Permission::findOrCreate('employee_category.show');
        Permission::findOrCreate('employee_category.edit');
        Permission::findOrCreate('employee_category.delete');

        //////////// Permission for hr-branch creation in G setting
        Permission::findOrCreate('hr_branch.icrud');
        Permission::findOrCreate('hr_branch.index');
        Permission::findOrCreate('hr_branch.create');
        Permission::findOrCreate('hr_branch.show');
        Permission::findOrCreate('hr_branch.edit');
        Permission::findOrCreate('hr_branch.delete');

        //////////////////////// Permsssion for language in G setting
        Permission::findOrCreate('language.icrud');
        Permission::findOrCreate('language.index');
        Permission::findOrCreate('language.create');
        Permission::findOrCreate('language.show');
        Permission::findOrCreate('language.edit');
        Permission::findOrCreate('language.delete');

        //////////////////////// Permsssion for  marital status in G setting
        Permission::findOrCreate('marital_status.icrud');
        Permission::findOrCreate('marital_status.index');
        Permission::findOrCreate('marital_status.create');
        Permission::findOrCreate('marital_status.show');
        Permission::findOrCreate('marital_status.edit');
        Permission::findOrCreate('marital_status.delete');

    ///////////////////// Permission for license_type in G setting
        Permission::findOrCreate('license_type.icrud');
        Permission::findOrCreate('license_type.index');
        Permission::findOrCreate('license_type.create');
        Permission::findOrCreate('license_type.show');
        Permission::findOrCreate('license_type.edit');
        Permission::findOrCreate('license_type.delete');
    //////////////// Permission for nationality in G setting
        Permission::findOrCreate('nationality.icrud');
        Permission::findOrCreate('nationality.index');
        Permission::findOrCreate('nationality.create');
        Permission::findOrCreate('nationality.show');
        Permission::findOrCreate('nationality.edit');
        Permission::findOrCreate('nationality.delete');

        //////////////// Permission for region in G setting
        Permission::findOrCreate('region.icrud');
        Permission::findOrCreate('region.index');
        Permission::findOrCreate('region.create');
        Permission::findOrCreate('region.show');
        Permission::findOrCreate('region.edit');
        Permission::findOrCreate('region.delete');

        //////////////// Permission for religion in G setting
        Permission::findOrCreate('religion.icrud');
        Permission::findOrCreate('religion.index');
        Permission::findOrCreate('religion.create');
        Permission::findOrCreate('religion.show');
        Permission::findOrCreate('religion.edit');
        Permission::findOrCreate('religion.delete');
        //////////////// Permission for skill-type in G setting
        Permission::findOrCreate('skill_type.icrud');
        Permission::findOrCreate('skill_type.index');
        Permission::findOrCreate('skill_type.create');
        Permission::findOrCreate('skill_type.show');
        Permission::findOrCreate('skill_type.edit');
        Permission::findOrCreate('skill_type.delete');
        //////////////// Permission for upload_file in G setting
        Permission::findOrCreate('upload_file.icrud');
        Permission::findOrCreate('upload_file.index');
        Permission::findOrCreate('upload_file.create');
        Permission::findOrCreate('upload_file.show');
        Permission::findOrCreate('upload_file.edit');
        Permission::findOrCreate('upload_file.delete');

///////// Permission for family_relationship in G setting
        Permission::findOrCreate('family_relationship.icrud');
        Permission::findOrCreate('family_relationship.index');
        Permission::findOrCreate('family_relationship.create');
        Permission::findOrCreate('family_relationship.show');
        Permission::findOrCreate('family_relationship.edit');
        Permission::findOrCreate('family_relationship.delete');
    
///////// Permission for type_of_leave in G setting
        Permission::findOrCreate('type_of_leave.icrud');
        Permission::findOrCreate('type_of_leave.index');
        Permission::findOrCreate('type_of_leave.create');
        Permission::findOrCreate('type_of_leave.show');
        Permission::findOrCreate('type_of_leave.edit');
        Permission::findOrCreate('type_of_leave.delete');

        ///////// Permission for type_of_misconduct in G setting
        Permission::findOrCreate('type_of_misconduct.icrud');
        Permission::findOrCreate('type_of_misconduct.index');
        Permission::findOrCreate('type_of_misconduct.create');
        Permission::findOrCreate('type_of_misconduct.show');
        Permission::findOrCreate('type_of_misconduct.edit');
        Permission::findOrCreate('type_of_misconduct.delete');

        ///////// Permission for template in G setting
        Permission::findOrCreate('template.icrud');
        Permission::findOrCreate('template.index');
        Permission::findOrCreate('template.create');
        Permission::findOrCreate('template.show');
        Permission::findOrCreate('template.edit');
        Permission::findOrCreate('template.delete');
        ///////// Permission for template_type in G setting
        Permission::findOrCreate('template_type.icrud');
        Permission::findOrCreate('template_type.index');
        Permission::findOrCreate('template_type.create');
        Permission::findOrCreate('template_type.show');
        Permission::findOrCreate('template_type.edit');
        Permission::findOrCreate('template_type.delete');
        
    
// Permission for educational Level in G setting
        Permission::findOrCreate('education_level.icrud');
        Permission::findOrCreate('education_level.index');
        Permission::findOrCreate('education_level.create');
        Permission::findOrCreate('education_level.show');
        Permission::findOrCreate('education_level.edit');
        Permission::findOrCreate('education_level.delete');

        // Permission for certification_type in G setting
        Permission::findOrCreate('certification_type.icrud');
        Permission::findOrCreate('certification_type.index');
        Permission::findOrCreate('certification_type.create');
        Permission::findOrCreate('certification_type.show');
        Permission::findOrCreate('certification_type.edit');
        Permission::findOrCreate('certification_type.delete');
        
////////////////////////////////////////////////////////////////////////////////
        // Permission for job_title_category
        Permission::findOrCreate('job_title_category.icrud');
        Permission::findOrCreate('job_title_category.index');
        Permission::findOrCreate('job_title_category.create');
        Permission::findOrCreate('job_title_category.show');
        Permission::findOrCreate('job_title_category.edit');
        Permission::findOrCreate('job_title_category.delete');
        // Permission for job_title_category add field of study
        Permission::findOrCreate('job_title_category.field_of_study.icrud');
        Permission::findOrCreate('job_title_category.field_of_study.index');
        Permission::findOrCreate('job_title_category.field_of_study.create');
        Permission::findOrCreate('job_title_category.field_of_study.show');
        Permission::findOrCreate('job_title_category.field_of_study.edit');
        Permission::findOrCreate('job_title_category.field_of_study.delete');

        // Permission for job_title_category add job title
        Permission::findOrCreate('job_title_category.job_title.icrud');
        Permission::findOrCreate('job_title_category.job_title.index');
        Permission::findOrCreate('job_title_category.job_title.create');
        Permission::findOrCreate('job_title_category.job_title.show');
        Permission::findOrCreate('job_title_category.job_title.edit');
        Permission::findOrCreate('job_title_category.job_title.delete');

        // Permission for job level
        Permission::findOrCreate('job_level.icrud');
        Permission::findOrCreate('job_level.index');
        Permission::findOrCreate('job_level.create');
        Permission::findOrCreate('job_level.show');
        Permission::findOrCreate('job_level.edit');
        Permission::findOrCreate('job_level.delete');

        // Permission for job grades
        Permission::findOrCreate('job_grade.icrud');
        Permission::findOrCreate('job_grade.index');
        Permission::findOrCreate('job_grade.create');
        Permission::findOrCreate('job_grade.show');
        Permission::findOrCreate('job_grade.edit');
        Permission::findOrCreate('job_grade.delete');
        // Permission for job grades
        Permission::findOrCreate('salary_increament.icrud');
        Permission::findOrCreate('salary_increament.index');
        Permission::findOrCreate('salary_increament.create');
        Permission::findOrCreate('salary_increament.show');
        Permission::findOrCreate('salary_increament.edit');
        Permission::findOrCreate('salary_increament.delete');

        // Permission for salary scale
        Permission::findOrCreate('salary_scale.icrud');
        Permission::findOrCreate('salary_scale.index');
        Permission::findOrCreate('salary_scale.create');
        Permission::findOrCreate('salary_scale.show');
        Permission::findOrCreate('salary_scale.edit');
        Permission::findOrCreate('salary_scale.delete');

        // Permission for employement type
        Permission::findOrCreate('employement_type.icrud');
        Permission::findOrCreate('employement_type.index');
        Permission::findOrCreate('employement_type.create');
        Permission::findOrCreate('employement_type.show');
        Permission::findOrCreate('employement_type.edit');
        Permission::findOrCreate('employement_type.delete');
        // Permission for position
        Permission::findOrCreate('position.icrud');
        Permission::findOrCreate('position.index');
        Permission::findOrCreate('position.create');
        Permission::findOrCreate('position.show');
        Permission::findOrCreate('position.edit');
        Permission::findOrCreate('position.delete');
        // Permission for evaluation category
        Permission::findOrCreate('evaluation_category.icrud');
        Permission::findOrCreate('evaluation_category.index');
        Permission::findOrCreate('evaluation_category.create');
        Permission::findOrCreate('evaluation_category.show');
        Permission::findOrCreate('evaluation_category.edit');
        Permission::findOrCreate('evaluation_category.delete');
        // Permission for evaluation level
        Permission::findOrCreate('evaluation_level.icrud');
        Permission::findOrCreate('evaluation_level.index');
        Permission::findOrCreate('evaluation_level.create');
        Permission::findOrCreate('evaluation_level.show');
        Permission::findOrCreate('evaluation_level.edit');
        Permission::findOrCreate('evaluation_level.delete');
        // Permission for evaluation criteria
        Permission::findOrCreate('criteria.icrud');
        Permission::findOrCreate('criteria.index');
        Permission::findOrCreate('criteria.create');
        Permission::findOrCreate('criteria.show');
        Permission::findOrCreate('criteria.edit');
        Permission::findOrCreate('criteria.delete');
        // Permission for evaluation
        Permission::findOrCreate('evaluation.icrud');
        Permission::findOrCreate('evaluation.index');
        Permission::findOrCreate('evaluation.create');
        Permission::findOrCreate('evaluation.show');
        Permission::findOrCreate('evaluation.edit');
        Permission::findOrCreate('evaluation.delete');
        // Permission for vacancy
        Permission::findOrCreate('vacancy.icrud');
        Permission::findOrCreate('vacancy.index');
        Permission::findOrCreate('vacancy.create');
        Permission::findOrCreate('vacancy.show');
        Permission::findOrCreate('vacancy.edit');
        Permission::findOrCreate('vacancy.delete');
        // Permission for vacancy candidates


        //   employment_statuses
        Permission::findOrCreate('employment_statuse.icrud');
        Permission::findOrCreate('employment_statuse.index');
        Permission::findOrCreate('employment_statuse.create');
        Permission::findOrCreate('employment_statuse.show');
        Permission::findOrCreate('employment_statuse.edit');
        Permission::findOrCreate('employment_statuse.delete');
            
        /////////////// Vacancy permssion //////////
        Permission::findOrCreate('vacancy.candidate.icrud');
        Permission::findOrCreate('vacancy.candidate.index');
        Permission::findOrCreate('vacancy.candidate.create');
        Permission::findOrCreate('vacancy.candidate.show');
        Permission::findOrCreate('vacancy.candidate.edit');
        Permission::findOrCreate('vacancy.candidate.delete');
        // Permission for vacancy candidates add mark
        Permission::findOrCreate('vacancy.candidate.mark.add');
        Permission::findOrCreate('vacancy.candidate.mark.edit');
        // Permission for vacancy candidates screen
        Permission::findOrCreate('vacancy.candidate.screen');
        // Permission for evaluation periods
        Permission::findOrCreate('evaluation_periods.icrud');
        Permission::findOrCreate('evaluation_periods.index');
        Permission::findOrCreate('evaluation_periods.create');
        Permission::findOrCreate('evaluation_periods.show');
        Permission::findOrCreate('evaluation_periods.edit');
        Permission::findOrCreate('evaluation_periods.delete');
        // Permission for efficency form style
        Permission::findOrCreate('efficency_form_style.icrud');
        Permission::findOrCreate('efficency_form_style.index');
        Permission::findOrCreate('efficency_form_style.create');
        Permission::findOrCreate('efficency_form_style.show');
        Permission::findOrCreate('efficency_form_style.edit');
        Permission::findOrCreate('efficency_form_style.delete');
        // Permission for salary increments
        Permission::findOrCreate('salary_increment.icrud');
        Permission::findOrCreate('salary_increment.index');
        Permission::findOrCreate('salary_increment.create');
        Permission::findOrCreate('salary_increment.show');
        Permission::findOrCreate('salary_increment.edit');
        Permission::findOrCreate('salary_increment.delete');
        // Signature
        Permission::findOrCreate('signature.icrud');
        Permission::findOrCreate('signature.index');
        Permission::findOrCreate('signature.create');
        Permission::findOrCreate('signature.show');
        Permission::findOrCreate('signature.edit');
        Permission::findOrCreate('signature.delete');

        // Application 
        Permission::findOrCreate('application.icrud');
        Permission::findOrCreate('application.index');
        Permission::findOrCreate('application.create');
        Permission::findOrCreate('application.show');
        Permission::findOrCreate('application.edit');
        Permission::findOrCreate('application.delete');

        // Application type
        Permission::findOrCreate('application_type.icrud');
        Permission::findOrCreate('application_type.index');
        Permission::findOrCreate('application_type.create');
        Permission::findOrCreate('application_type.show');
        Permission::findOrCreate('application_type.edit');
        Permission::findOrCreate('application_type.delete');

        Permission::findOrCreate('report_view');
        // clearance
        Permission::findOrCreate('clearance.icrud');
        Permission::findOrCreate('clearance.index');
        Permission::findOrCreate('clearance.create');
        Permission::findOrCreate('clearance.show');
        Permission::findOrCreate('clearance.edit');
         //  check-point
        Permission::findOrCreate('check_point.icrud');
        Permission::findOrCreate('check_point.index');
        Permission::findOrCreate('check_point.create');
        Permission::findOrCreate('check_point.show');
        Permission::findOrCreate('check_point.edit');
        Permission::findOrCreate('check_point.delete');
      
        // Hr Branch
        Permission::findOrCreate('HR-all.manage');
        Permission::findOrCreate('HR-jit.manage');
        Permission::findOrCreate('HR-jmc.manage');
        Permission::findOrCreate('HR-health-institue.manage');
        Permission::findOrCreate('HR-education-and-behavoral.manage');
        Permission::findOrCreate('HR-main.manage');
        Permission::findOrCreate('HR-agri.manage');
        Permission::findOrCreate('HR-social-and-science.manage');
        Permission::findOrCreate('HR-natural-and-science.manage');
        Permission::findOrCreate('HR-law-and-goverenace.manage');
        Permission::findOrCreate('HR-busiess-and-economics.manage');
        Permission::findOrCreate('HR-sport-and-science.manage');
        Permission::findOrCreate('HR-agaro.manage');
        // Employee placement
        Permission::findOrCreate('placement.manage');

     

        
    }
}
