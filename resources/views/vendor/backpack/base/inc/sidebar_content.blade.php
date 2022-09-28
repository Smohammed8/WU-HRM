<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->

<li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="la la-home nav-icon"></i>
        Home </a></li>

<li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}"><i class="la la-dashboard nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>

<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i>User Managment</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i>
                <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                    class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                    class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>

<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-sitemap"></i> Structure </a>
    <ul class="nav-dropdown-items">
        <!-- la la-angle-double-right ,la la-graduation-cap
-->
        {{-- @if (backpack_user()->hasPermissionTo('structure.show')) --}}
        {{-- @if (backpack_user()->hasRole('Admin')) --}}
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('organization') }}'><i
                    class='nav-icon la la-caret-right'></i> Organizations</a></li>

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('unit') }}'><i
                    class='nav-icon la la-caret-right'></i>
                Organizational Units</a></li>

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('job-title') }}'><i
                    class='nav-icon la la-caret-right'></i>
                Job titles</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('job-title-category') }}'><i
                    class='nav-icon la la-caret-right'></i> Job title categories</a></li>

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employment-type') }}'><i
                    class='nav-icon la la-caret-right'></i> Employment types</a></li>
    </ul>
</li>

{{-- @endif --}}
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-wrench"></i> Setting</a>
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
                    class='nav-icon la la-caret-right'></i> Employment status </a></li>

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('field-of-study') }}'><i
                    class='nav-icon la la-caret-right'></i> Field of studies</a></li>




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
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('skill') }}'><i
                    class='nav-icon la la-caret-right'></i>
                Skills</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('skill-type') }}'><i
                    class='nav-icon la la-caret-right'></i> Skill types</a></li>

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('upload-file') }}'><i
                    class='nav-icon la la-caret-right'></i> Upload files</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-relationship') }}'><i
                    class='nav-icon la la-caret-right'></i> Family relationships</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('minimum-requirement') }}'><i
                    class='nav-icon la la-question'></i> Minimum requirements</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('position') }}'><i
                    class='nav-icon la la-question'></i> Positions</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('related-work') }}'><i
                    class='nav-icon la la-question'></i> Related works</a></li>
    </ul>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee') }}'><i class='nav-icon la la-list'></i>
        Employees</a></li>




<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-flag"></i> Efficiency </a>
    <ul class="nav-dropdown-items">

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-evaluation') }}'><i
                    class='nav-icon la la-caret-right'></i> Evaluation Result</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evaluation-category') }}'><i
                    class='nav-icon la la-caret-right'></i> Evaluation category</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evaluation-level') }}'><i
                    class='nav-icon la la-caret-right'></i> Evaluation levels</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('evalution-creteria') }}'><i
                    class='nav-icon la la-caret-right'></i> Evalution creterias</a></li>

    </ul>
</li>
