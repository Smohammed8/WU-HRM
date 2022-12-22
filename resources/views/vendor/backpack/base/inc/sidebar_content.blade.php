<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@can('employee.home')
    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="la la-home nav-icon"></i>
            Home </a></li>
@endcan
@can('dashboard.content')
    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="la la-dashboard nav-icon"></i>
            {{ trans('backpack::base.dashboard') }}</a>
    </li>
@endcan
@canany(['user.icrud', 'user.index', 'role.icrud', 'role.index', 'permission.icrud', 'permission.index'])
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i>User Managment</a>
        <ul class="nav-dropdown-items">
            @canany(['user.index', 'user.icrud'])
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i>
                        <span>Users</span></a></li>
            @endcanany
            @canany(['role.index', 'role.icrud'])
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                            class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
            @endcanany
            @canany(['permission.index', 'permission.icrud'])
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                            class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
            @endcanany
        </ul>
    </li>
@endcanany
<!-- Users, Roles, Permissions -->

@canany(['id.design.icrud', 'id.design.index'])
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-id-card"></i>ID</a>
        <ul class="nav-dropdown-items">
            @canany(['id.design.icrud', 'id.design.index'])
                <li class="nav-item"><a class="nav-link" href="{{ route('idcard.index') }}">
                        <i class="nav-icon la la-user"></i>
                        <span>ID Design</span></a></li>
            @endcanany
            @canany(['id.setting.icrud', 'id.setting.index'])
                <li class="nav-item"><a class="nav-link" href="{{ route('attribute.index') }}">
                        <i class="nav-icon la la-id-badge"></i>
                        <span>ID Setting</span></a>
                </li>
            @endcanany
        </ul>
    </li>
@endcanany
@can('employee.index')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee') }}'><i class='nav-icon la la-user-tie'></i>
            Employees</a></li>
@endcan
@canany(['organization.index', 'organization.icrud', 'unit.index', 'unit.icrud'])
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-sitemap"></i> Org. Structure</a>
        <ul class="nav-dropdown-items">
            @canany(['organization.index', 'organization.icrud'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('organization') }}'>
                        <i class='nav-icon la la-caret-right'></i>Organizations</a></li>
            @endcanany
            @canany(['unit.index', 'unit.icrud'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('unit') }}'>
                        <i class='nav-icon la la-caret-right'></i> Organizational Units</a></li>
            @endcanany

        </ul>
    </li>
@endcanany
@canany(['setting.index', 'setting.icrud'])
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-wrench"></i>General settings</a>
        <ul class="nav-dropdown-items">
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('chair-man-type') }}'><i
                        class='nav-icon la la-caret-right'></i> Chair man types</a></li>

            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pension') }}'>
                    <i class='nav-icon la la-caret-right'></i> Pensions</a></li>


            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('educational-level') }}'><i
                        class='nav-icon la la-caret-right'></i> Educational levels</a></li>

            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-title') }}'><i
                        class='nav-icon la la-caret-right'></i> Employee titles</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('ethnicity') }}'><i
                        class='nav-icon la la-caret-right'></i>
                    Ethnicities</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-category') }}'><i
                        class='nav-icon la la-caret-right'></i> Employment categoty </a></li>

            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('field-of-study') }}'><i
                        class='nav-icon la la-caret-right'></i> Field of studies</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('quarter') }}'><i
                        class='nav-icon la la-caret-right'></i>Quarters</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('language') }}'><i
                        class='nav-icon la la-caret-right'></i> Languages</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('marital-status') }}'><i
                        class='nav-icon la la-caret-right'></i> Marital statuses</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('license-type') }}'><i
                        class='nav-icon la la-caret-right'></i> License types</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('nationality') }}'><i
                        class='nav-icon la la-caret-right'></i> Nationalities</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('region') }}'><i
                        class='nav-icon la la-caret-right'></i> Regions</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('religion') }}'><i
                        class='nav-icon la la-caret-right'></i> Religions</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('skill-type') }}'><i
                        class='nav-icon la la-caret-right'></i> Skill types</a></li>

            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('upload-file') }}'><i
                        class='nav-icon la la-caret-right'></i> Upload files</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-relationship') }}'> <i
                        class='nav-icon la la-caret-right'></i> Family relationships</a></li>

            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('type-of-leave') }}'><i
                        class='nav-icon la la-caret-right'></i> Type of leaves</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('type-of-misconduct') }}'><i
                        class='nav-icon la la-caret-right'></i>Type of misconducts</a></li>

            <!-- //////////////////////////////////////////////////////// -->
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('template') }}'>
                    <i class='nav-icon la la-caret-right'></i> Templates</a></li>


            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('template-type') }}'>

                    <i class='nav-icon la la-caret-right'></i> Template types</a></li>
            <!-- /////////////////////////////////////////////////////////////-->
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
                        <i class='nav-icon la la-caret-right'></i>Job title categories</a></li>
            @endcanany
            @canany(['job_level.icrud', 'job_level.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('level') }}'>
                        <i class='nav-icon la la-caret-right'></i>Job Levels</a></li>
            @endcanany
            @canany(['job_grade.icrud', 'job_grade.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('job-grade') }}'>
                        <i class='nav-icon la la-caret-right'></i> Job grades</a></li>
            @endcanany
            @canany(['salary_scale.icrud', 'salary_scale.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('salary-scale') }}'>
                        <i class='nav-icon la la-caret-right'></i> Salary scales</a></li>
            @endcanany
            @canany(['employement_type.icrud', 'employement_type.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employment-type') }}'>
                        <i class='nav-icon la la-caret-right'></i>Employment types</a></li>
            @endcanany
            @canany(['position.icrud', 'position.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('position') }}'><i
                            class='nav-icon la la-caret-right'></i> Positions</a></li>
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
                            class='nav-icon la la-caret-right'></i> Evaluation levels</a></li>
            @endcanany
            @canany(['criteria.icrud', 'criteria.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evalution-creteria') }}'><i
                            class='nav-icon la la-caret-right'></i> Evalution creterias</a></li>
            @endcanany
            @canany(['evaluation.index', 'evaluation.icrud'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evaluation') }}'><i
                            class='nav-icon la la-caret-right'></i> Evaluations</a></li>
            @endcanany
        </ul>
    </li>
@endcanany

{{-- <li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-th-list"></i>Employee Placement </a>


    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('position-requirement') }}'><i
                    class='nav-icon la la-caret-right'></i>Requirements</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('position-type') }}'><i
                    class='nav-icon la la-caret-right'></i> Position types</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('position-value') }}'><i
                    class='nav-icon la la-caret-right'></i> Position values</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('education-comparison-criteria') }}'><i
                    class='nav-icon la la-caret-right'></i> Education criterias</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('experience-comparison-criteria') }}'><i
                    class='nav-icon la la-caret-right'></i> Experience criterias</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('placement-round') }}'><i
                    class='nav-icon la la-caret-right'></i> Placement rounds</a></li>
    </ul>

</li> --}}
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
                            class='nav-icon la la-caret-right'></i>Demotions</a></li>
            @endcanany

            @canany(['employee.leave.index', 'employee.leave.icrud'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('leave') }}'> <i
                            class='nav-icon la la-caret-right'></i> Leaves</a></li>
            @endcanany

            @canany(['employee.discipline.index', 'employee.discipline.icrud'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('misconduct') }}'><i
                            class='nav-icon la la-caret-right'></i> Misconducts</a></li>
            @endcanany

            @canany(['employee.promotion.index', 'employee.promotion.icrud'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('promotion') }}'><i
                            class='nav-icon la la-caret-right'></i> Promotions</a></li>
            @endcanany
        </ul>
    </li>
@endcanany
@canany(['evaluation_periods.icrud', 'evaluation_periods.index', 'efficency_form_style.icrud',
    'efficency_form_style.index', 'salary_increment.icrud', 'salary_increment.index'])
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-list"></i> Configurations </a>
        <ul class="nav-dropdown-items">

            @canany(['evaluation_periods.icrud', 'evaluation_periods.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evaluation-period') }}'><i
                            class='nav-icon la la-caret-right'></i> Evaluation periods</a></li>
            @endcanany
            @canany(['efficency_form_style.icrud', 'efficency_form_style.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('form-style') }}'> <i
                            class='nav-icon la la-caret-right'></i> Efficiency Form style</a></li>
            @endcanany
            @canany(['salary_increment.icrud', 'salary_increment.index'])
                <li class='nav-item'><a class='nav-link' href='{{ backpack_url('salary-increament') }}'><i
                            class='nav-icon la la-caret-right'></i> Salary increaments</a></li>
            @endcanany

        </ul>
    </li>
@endcanany


<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-print"></i> Reports</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='#'> <i
                    class='nav-icon la la-caret-right'></i>Efficiency</a></li>
        <li class='nav-item'><a class='nav-link' href='#'> <i class='nav-icon la la-caret-right'></i>
                Retirements </a></li>
        <li class='nav-item'><a class='nav-link' href='#'> <i class='nav-icon la la-caret-right'></i> Leaves
            </a></li>
        <li class='nav-item'><a class='nav-link' href='#'> <i class='nav-icon la la-caret-right'></i>
                Recruitments</a></li>
    </ul>
</li>
