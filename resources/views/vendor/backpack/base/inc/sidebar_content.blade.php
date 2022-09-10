<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>

<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i>
                <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                    class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                    class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-gear"></i> Setting</a>
    <ul class="nav-dropdown-items">


        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('chair-man-type') }}'><i
                    class='nav-icon la la-question'></i> Chair man types</a></li>

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('educational-level') }}'><i
                    class='nav-icon la la-question'></i> Educational levels</a></li>

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-title') }}'><i
                    class='nav-icon la la-question'></i> Employee titles</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('ethnicity') }}'><i
                    class='nav-icon la la-question'></i>
                Ethnicities</a></li>


        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-category') }}'><i
                    class='nav-icon la la-question'></i> Employee categories</a></li>

        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employment-status') }}'><i
                    class='nav-icon la la-question'></i> Employment statuses</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employment-type') }}'><i
                    class='nav-icon la la-question'></i> Employment types</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('field-of-study') }}'><i
                    class='nav-icon la la-question'></i> Field of studies</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('job-title') }}'><i
                    class='nav-icon la la-question'></i>
                Job titles</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('job-title-category') }}'><i
                    class='nav-icon la la-question'></i> Job title categories</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('language') }}'><i
                    class='nav-icon la la-question'></i> Languages</a></li>


        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('marital-status') }}'><i
                    class='nav-icon la la-question'></i> Marital statuses</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('license-type') }}'><i
                    class='nav-icon la la-question'></i> License types</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('nationality') }}'><i
                    class='nav-icon la la-question'></i> Nationalities</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('region') }}'><i
                    class='nav-icon la la-question'></i> Regions</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('religion') }}'><i
                    class='nav-icon la la-question'></i> Religions</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('skill') }}'><i
                    class='nav-icon la la-question'></i>
                Skills</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('skill-type') }}'><i
                    class='nav-icon la la-question'></i> Skill types</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('unit') }}'><i
                    class='nav-icon la la-question'></i>
                Units</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('upload-file') }}'><i
                    class='nav-icon la la-question'></i> Upload files</a></li>
    </ul>
</li>





<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee') }}'><i
            class='nav-icon la la-question'></i>
        Employees</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('license') }}'><i
            class='nav-icon la la-question'></i>
        Licenses</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-address') }}'><i
            class='nav-icon la la-question'></i> Employee addresses</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-certificate') }}'><i
            class='nav-icon la la-question'></i> Employee certificates</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-contact') }}'><i
            class='nav-icon la la-question'></i> Employee contacts</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-family') }}'><i
            class='nav-icon la la-question'></i> Employee families</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee-language') }}'><i
            class='nav-icon la la-question'></i> Employee languages</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('external-experience') }}'><i
            class='nav-icon la la-question'></i> External experiences</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('family-relationship') }}'><i
            class='nav-icon la la-question'></i> Family relationships</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('internal-experience') }}'><i
            class='nav-icon la la-question'></i> Internal experiences</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('organization') }}'><i
            class='nav-icon la la-question'></i> Organizations</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('pension') }}'><i
            class='nav-icon la la-question'></i> Pensions</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('training-and-study') }}'><i
            class='nav-icon la la-question'></i> Training and studies</a></li>
