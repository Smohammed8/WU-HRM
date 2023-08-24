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
        // Permission for setting
        Permission::findOrCreate('setting.icrud');
        Permission::findOrCreate('setting.index');
        Permission::findOrCreate('setting.create');
        Permission::findOrCreate('setting.show');
        Permission::findOrCreate('setting.edit');
        Permission::findOrCreate('setting.delete');

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

        // Permission for employee operation efficency
        Permission::findOrCreate('employee.efficency.icrud');
        Permission::findOrCreate('employee.efficency.index');
        Permission::findOrCreate('employee.efficency.create');
        Permission::findOrCreate('employee.efficency.show');
        Permission::findOrCreate('employee.efficency.edit');
        Permission::findOrCreate('employee.efficency.delete');

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
