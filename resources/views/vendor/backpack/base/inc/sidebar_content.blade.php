
<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->



<li class="nav-item"><a class="nav-link" href="#"><i class="la la-home nav-icon"></i>
    Home </a>
</li>


@can('dashboard.content')
<li class="nav-item">
<a class="nav-link"  id="dash" href="{{ route('dashboard') }}"><i class="la la-dashboard nav-icon"></i>
    Dashboard 
</a>
</li>
@endcan

@can('employee.home')
<li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="la la-user-tie nav-icon"></i>
    My Profile </a>
</li>
@endcan
<style>
#dash {

background-color: white !important;
color:black;

}
</style>



@canany(['user.icrud', 'user.index', 'role.icrud', 'role.index', 'permission.icrud', 'permission.index'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-user"></i> User Managment</a>
<ul class="nav-dropdown-items">
    @canany(['user.index', 'user.icrud'])
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}">   <i class='nav-icon la la-caret-right'></i> 
                <span>User list</span></a></li>
    @endcanany
    @canany(['role.index', 'role.icrud'])
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}">
            <i class='nav-icon la la-caret-right'></i> 
             <span> User group </span></a></li>
    @endcanany
    @canany(['permission.index', 'permission.icrud'])
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}">
            <i class='nav-icon la la-caret-right'></i> 
            <span> Permission</span></a></li>
    @endcanany
</ul>
</li>
@endcanany
<!-- Users, Roles, Permissions -->

@canany(['id.design.icrud', 'id.design.index'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-id-card"></i>ID Managment</a>
<ul class="nav-dropdown-items">
    @canany(['id.design.icrud', 'id.design.index'])
        <li class="nav-item"><a class="nav-link" href="{{ route('idcard.index') }}">
            <i class='nav-icon la la-caret-right'></i> 
                <span>ID Design</span></a></li>
    @endcanany
    @canany(['id.setting.icrud', 'id.setting.index'])
        <li class="nav-item"><a class="nav-link" href="{{ route('attribute.index') }}">
            <i class='nav-icon la la-caret-right'></i> 
                <span>ID Setting</span></a>
        </li>
    @endcanany
    @canany(['signature.icrud', 'signature.index'])
        <li class="nav-item"><a class="nav-link" href="{{ route('signature.index') }}">
            <i class='nav-icon la la-caret-right'></i> 
                <span>Signature</span></a>
        </li>
    @endcanany
</ul>
</li>
@endcanany

{{-- @can('employee.index')
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee') }}'>
    <i style="color:black;"  class='nav-icon la la-user-tie'></i>
    Employee Managment </a></li>
@endcan --}}

@can('employee.index')
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"> <i style="color:black;"  class='nav-icon la la-user-tie'></i>
    Employee Managment</a>
<ul class="nav-dropdown-items">
    @can('employee.index')
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('employee') }}">
            <i class='nav-icon la la-caret-right'></i> 
                <span>All Employees</span></a></li>
    @endcanany
    @canany('contract.employee.index')
        <li class="nav-item"><a class="nav-link" href="#">
            <i class='nav-icon la la-caret-right'></i> 
                <span>Contract Employees</span></a>
        </li>
    @endcanany
 
    @canany('temporary.employee.index')
        <li class="nav-item"><a class="nav-link" href="#">
            <i class='nav-icon la la-caret-right'></i> 
                <span>Temporary Employees</span></a>
        </li>
    @endcanany
    @canany('left.employee.index')
    <li class="nav-item"><a class="nav-link" href="{{ route('employee.checkLeave') }}">
        <i class='nav-icon la la-caret-right'></i> 
            <span>Left Employees</span></a>
    </li>
     @endcanany

     @canany('probation.employee.index')
     <li class="nav-item"><a class="nav-link" href="{{ route('employee.probation', []) }}">
        <i class='nav-icon la la-caret-right'></i> 
             <span>Under Probation Period</span></a>
     </li>
      @endcanany

      @canany('retirment.employee.index')
      <li class="nav-item"><a class="nav-link" href="{{ route('employee.checkRetirment', []) }}">
        <i class='nav-icon la la-caret-right'></i> 
              <span>Active Retirments</span></a>
      </li>
       @endcanany
       @canany('error.logs.index')
       <li class="nav-item"><a class="nav-link" href="{{ route('suspected_errors') }}">
         <i class='nav-icon la la-caret-right'></i> 
               <span>Suspected Errors</span></a>
       </li>
        @endcanany

</ul>
</li>
@endcanany

@canany(['organization.index', 'organization.icrud', 'unit.index', 'unit.icrud'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-institution"></i> Organization   </a>
<ul class="nav-dropdown-items"> 
  


    @canany(['organization.index', 'organization.icrud'])
        {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('organization') }}'> --}}
            <li class='nav-item'><a class='nav-link' href='{{ route('hierarchy') }}'>
                <i class='nav-icon la la-caret-right'></i> Org. Structure </a></li>
    @endcanany
    @canany(['unit.index', 'unit.icrud'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('unit') }}'>
                <i class='nav-icon la la-caret-right'></i> Organizational Unit</a></li>
    @endcanany

    {{-- @canany(['organization.index', 'organization.icrud'])

        <li class='nav-item'><a class='nav-link' href='{{ route('structure-pdf') }}'>
            <i class='nav-icon la la-caret-right'></i> Structure  PDF</a>
        </li>
        @endcanany --}}

</ul>
</li>
@endcanany

<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-user-minus"></i> Clearance </a>
<ul class="nav-dropdown-items">
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('check-point') }}'><i class='nav-icon la la-caret-right'></i> Check points</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('clearance') }}'><i class='nav-icon la la-caret-right'></i> </i> Clearances</a></li>
<li class='nav-item'><a class='nav-link' href='#'> <i class='nav-icon la la-caret-right'></i> Employee Approvals </a></li>
<li class='nav-item'><a class='nav-link' href='#'> <i class='nav-icon la la-caret-right'></i> Order Policy</a></li>

</ul>
</li>


@canany(['setting.index', 'setting.icrud'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-wrench"></i>General setting</a>
<ul class="nav-dropdown-items">
    {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('chair-man-type') }}'><i
                class='nav-icon la la-caret-right'></i> Chairman type</a></li> --}}



    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pension') }}'>
            <i class='nav-icon la la-caret-right'></i>Set  pension</a></li>
    @canany(['certification_type.index', 'certification_type.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('certification-type') }}'><i class='nav-icon la la-caret-right'></i> Certification type </a></li>
    @endcanany
    
    @canany(['education_level.index', 'education_level.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('educational-level') }}'><i
                class='nav-icon la la-caret-right'></i> Educational level</a></li>
    @endcanany
    @canany(['employee_title.index', 'employee_title.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-title') }}'><i
                class='nav-icon la la-caret-right'></i> Employee title</a></li>
    @endcanany

    @canany(['ethnicity.index', 'ethnicity.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('ethnicity') }}'><i
                class='nav-icon la la-caret-right'></i>
            Ethnicities</a></li>
    @endcanany
    
    @canany(['employee_category.index', 'employee_category.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-category') }}'><i
                class='nav-icon la la-caret-right'></i> Employee category </a></li>
    @endcanany

    @canany(['field_of_study.index', 'field_of_study.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('field-of-study') }}'><i
                class='nav-icon la la-caret-right'></i> Field of study</a></li>
   @endcanany
   @canany(['hr_branch.index', 'hr_branch.icrud'])
     <li class='nav-item'><a class='nav-link' href='{{ backpack_url('hr-branch') }}'><i class='nav-icon la la-caret-right'></i> Hr branches</a></li>
     @endcanany

     @canany(['language.index', 'language.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('language') }}'>
        <i class='nav-icon la la-caret-right'></i> Language </a></li>
    @endcanany

    @canany(['marital_status.index', 'marital_status.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('marital-status') }}'><i
                class='nav-icon la la-caret-right'></i> Marital status</a></li>
     @endcanany

     @canany(['license_type.index', 'license_type.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('license-type') }}'><i
                class='nav-icon la la-caret-right'></i> License type</a></li>
     @endcanany

     @canany(['nationality.index', 'nationality.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('nationality') }}'><i
                class='nav-icon la la-caret-right'></i> Nationality</a></li>
    @endcanany
    @canany(['region.index', 'region.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('region') }}'><i
                class='nav-icon la la-caret-right'></i> Regions</a></li>
    @endcanany
    @canany(['religion.index', 'religion.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('religion') }}'><i
                class='nav-icon la la-caret-right'></i> Religion</a></li>
    @endcanany
    @canany(['skill_type.index', 'skill_type.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('skill-type') }}'><i
                class='nav-icon la la-caret-right'></i> Skill type</a></li>
    @endcanany

    @canany(['upload_file.index', 'upload_file.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('upload-file') }}'><i
                class='nav-icon la la-caret-right'></i> Upload files</a></li>
    @endcanany
    @canany(['family_relationship.index', 'family_relationship.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-relationship') }}'>
         <i class='nav-icon la la-caret-right'></i> Family relationship</a></li>
    @endcanany

    @canany(['type_of_leave.index', 'type_of_leave.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('type-of-leave') }}'><i
                class='nav-icon la la-caret-right'></i> Type of leave</a></li>
    @endcanany

    @canany(['type_of_misconduct.index', 'type_of_misconduct.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('type-of-misconduct') }}'>
        <i class='nav-icon la la-caret-right'></i>Type of misconduct</a></li>
    @endcanany
    @canany(['template.index', 'template.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('template') }}'>
            <i class='nav-icon la la-caret-right'></i> Template</a></li>

    @endcanany
    @canany(['template_type.index', 'template_type.icrud'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('template-type') }}'>

            <i class='nav-icon la la-caret-right'></i> Template type</a></li>
    @endcanany`
</ul>
</li>
@endcanany
@canany(['job_title_category.icrud', 'job_title_category.index', 'job_level.icrud', 'job_level.index',
'job_grade.icrud', 'job_grade.index', 'salary_scale.icrud', 'salary_scale.index', 'employement_type.icrud',
'employement_type.index', 'position.icrud', 'position.index'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-flag"></i>Job Information </a>
<ul class="nav-dropdown-items">
    @canany(['job_title_category.icrud', 'job_title_category.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('job-title-category') }}'>
                <i class='nav-icon la la-caret-right'></i>Job title category</a></li>
    @endcanany
    @canany(['job_level.icrud', 'job_level.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('level') }}'>
                <i class='nav-icon la la-caret-right'></i>Job Level</a></li>
    @endcanany
    @canany(['job_grade.icrud', 'job_grade.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('job-grade') }}'>
                <i class='nav-icon la la-caret-right'></i> Job grade</a></li>
    @endcanany
    @canany(['collegePositionCode.icrud', 'collegePositionCode.index'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('college-position-code') }}'><i class='nav-icon la la-caret-right'></i> College Position Code</a></li>
    @endcanany

    @canany(['employment_statuse.icrud', 'employment_statuse.index'])
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employment-status') }}'>
    <i class='nav-icon la la-caret-right'></i> Employement Status</a></li>
    @endcanany
        

    @canany(['salary_scale.icrud', 'salary_scale.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('salary-scale') }}'>
                <i class='nav-icon la la-caret-right'></i> Salary scale</a></li>
    @endcanany
    @canany(['employement_type.icrud', 'employement_type.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employment-type') }}'>
                <i class='nav-icon la la-caret-right'></i>Employment type</a></li>
    @endcanany
    @canany(['position.icrud', 'position.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('position') }}'><i
                    class='nav-icon la la-caret-right'></i> Position</a></li>
    @endcanany
</ul>
</li>
@endcanany
@canany(['evaluation_category.icrud', 'evaluation_category.index', 'evaluation_level.icrud', 'evaluation_level.index',
'criteria.icrud', 'criteria.index', 'evaluation.index', 'evaluation.icrud'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-balance-scale"></i> Efficiency
    settings
</a>
<ul class="nav-dropdown-items">
    {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-evaluation') }}'><i
            class='nav-icon la la-caret-right'></i> Evaluation Result</a></li> --}}
    @canany(['evaluation_category.icrud', 'evaluation_category.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evaluation-category') }}'><i
                    class='nav-icon la la-caret-right'></i> Evaluation category</a></li>
    @endcanany
    @canany(['evaluation_level.icrud', 'evaluation_level.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evaluation-level') }}'><i
                    class='nav-icon la la-caret-right'></i> Evaluation level</a></li>
    @endcanany
    @canany(['criteria.icrud', 'criteria.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evalution-creteria') }}'><i
                    class='nav-icon la la-caret-right'></i> Evalution creteria</a></li>
    @endcanany


    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('quarter') }}'><i
        class='nav-icon la la-caret-right'></i>Evalution periods </a></li>


    @canany(['evaluation.index', 'evaluation.icrud'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evaluation') }}'><i
                    class='nav-icon la la-caret-right'></i> Evaluation </a></li>
    @endcanany
</ul>
</li>
@endcanany

@canany(['placement.manage'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#">
<i class="nav-icon la la-th-list"></i> Employee Placement </a>


<ul class="nav-dropdown-items">
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('position-requirement') }}'><i
            class='nav-icon la la-caret-right'></i>Requirement</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('position-type') }}'><i
            class='nav-icon la la-caret-right'></i> Position type</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('position-value') }}'><i
            class='nav-icon la la-caret-right'></i> Position values</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('education-comparison-criteria') }}'><i
            class='nav-icon la la-caret-right'></i> Education criteria</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('experience-comparison-criteria') }}'><i
            class='nav-icon la la-caret-right'></i> Experience criteria</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('placement-round') }}'><i
            class='nav-icon la la-caret-right'></i> Placement Round</a></li>

{{-- 
            <li class='nav-item'><a class='nav-link' href="{{route('result') }}"><i
                class='nav-icon la la-caret-right'></i> Placement  result </a></li>


<li class='nav-item'><a class='nav-link' href="{{ backpack_url('committee') }}"><i
                    class='nav-icon la la-caret-right'></i> Committees </a></li>           


<li class='nav-item'><a class='nav-link' href="{{ backpack_url('complaint') }}"><i
                    class='nav-icon la la-caret-right'></i> Placement Complaints </a></li>    --}}
                    
            

             
</ul>

</li>
@endcanany


@canany(['payroll.icrud', 'payroll.index', 'payroll_sheet.icrud', 'payroll_sheet.index','payroll_history.icrud', 'payroll_history.index'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-balance-scale"></i>  Payroll
    managment
</a>
<ul class="nav-dropdown-items">

    @canany(['payroll.icrud', 'payroll.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('payroll') }}'><i
                    class='nav-icon la la-caret-right'></i> Payroll</a></li>
    @endcanany
    @canany(['payroll_sheet.icrud', 'payroll_sheet.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('payroll-sheet') }}'><i
                    class='nav-icon la la-caret-right'></i> Payrol Sheet</a></li>
    @endcanany
    @canany(['payroll_history.icrud', 'payroll_history.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('payroll-history') }}  '><i
                    class='nav-icon la la-caret-right'></i>  Payment history</a></li>
    @endcanany


</ul>
</li>
@endcanany


@canany(['vacancy.icrud', 'vacancy.index'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-user-plus"></i> Recruitment
</a>
<ul class="nav-dropdown-items">
    @canany(['vacancy.icrud', 'vacancy.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('vacancy') }}'> <i
                    class='nav-icon la la-caret-right'>
                </i>Vacancy</a></li>
    @endcanany
</ul>
</li>
@endcanany

@canany(['employee.demotion.index', 'employee.demotion.icrud', 'employee.leave.index', 'employee.leave.icrud',
'employee.discipline.index', 'employee.discipline.icrud', 'employee.promotion.index', 'employee.promotion.icrud'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-user-minus"></i>Leave Managment
</a>
<ul class="nav-dropdown-items">

    @canany(['employee.demotion.index', 'employee.demotion.icrud'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('demotion') }}'> <i
                    class='nav-icon la la-caret-right'></i>Demotion</a></li>
    @endcanany

    @canany(['employee.leave.index', 'employee.leave.icrud'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('leave') }}'> <i
                    class='nav-icon la la-caret-right'></i> Leaves</a></li>
    @endcanany

    @canany(['employee.discipline.index', 'employee.discipline.icrud'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('misconduct') }}'><i
                    class='nav-icon la la-caret-right'></i> Misconduct</a></li>
    @endcanany

    @canany(['employee.promotion.index', 'employee.promotion.icrud'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('promotion') }}'><i
                    class='nav-icon la la-caret-right'></i> Promotion</a></li>
    @endcanany
</ul>
</li>
@endcanany
@canany(['evaluation_periods.icrud', 'evaluation_periods.index', 'efficency_form_style.icrud',
'efficency_form_style.index', 'salary_increment.icrud', 'salary_increment.index'])
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-list"></i> Configuration </a>
<ul class="nav-dropdown-items">

    @canany(['evaluation_periods.icrud', 'evaluation_periods.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evaluation-period') }}'><i
                    class='nav-icon la la-caret-right'></i>Set  evaluation period</a></li>
    @endcanany
    @canany(['efficency_form_style.icrud', 'efficency_form_style.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('form-style') }}'> <i
                    class='nav-icon la la-caret-right'></i> Efficiency Form style</a></li>
    @endcanany
    @canany(['salary_increment.icrud', 'salary_increment.index'])
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('salary-increament') }}'><i
                    class='nav-icon la la-caret-right'></i> Salary increament</a></li>
    @endcanany

</ul>
</li>
@endcanany




<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-print"></i> Report </a>
<ul class="nav-dropdown-items">
<li class='nav-item'><a class='nav-link' href='#'> <i
            class='nav-icon la la-caret-right'></i>Efficiency</a></li>
<li class='nav-item'><a class='nav-link' href='#'> <i class='nav-icon la la-caret-right'></i>
        Retirement </a></li>
<li class='nav-item'><a class='nav-link' href='#'> <i class='nav-icon la la-caret-right'></i> Leave
    </a></li>
<li class='nav-item'><a class='nav-link' href='#'> <i class='nav-icon la la-caret-right'></i>
        Recruitments</a></li>
</ul>
</li>

{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('position-code') }}'><i class='nav-icon la la-question'></i> Position codes</a></li> --}}
