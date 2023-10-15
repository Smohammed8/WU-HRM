@extends(backpack_view('blank'))


<style>
    body {
        font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;

    }
</style>
@section('content')
    @cannot('dashboard.content')
        <h3 class="text-center"> Welcome to {{ env('APP_NAME') }}</h3>
    @endcan
    @can('dashboard.content')
        <br>
<h5> System Discovered Errors </h5>
        <hr>
        <p>

            <button class="btn  btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse" data-target=".multi-collapse"
                aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>

                 Employed date errors</button>

            <button class="btn btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse2" aria-expanded="false"
                aria-controls="multiCollapseExample4 multiCollapseExample3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Job codes erros</button>

            <button class="btn btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse3" aria-expanded="false"
                aria-controls="multiCollapseExample5 multiCollapseExample6"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Birth date errors </button>


                <button class="btn btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse3" aria-expanded="false"
                aria-controls="multiCollapseExample5 multiCollapseExample6"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Phone related Errors </button>

                <button class="btn btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse3" aria-expanded="false"
                aria-controls="multiCollapseExample5 multiCollapseExample6"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Exerience Errors </button>

        </p>


      
        
      
          <!-- /////////////////////////////////////////////// -->
          <div class="row">
            <div class="col">
               
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">

                        <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> FullName</th>
                                    <th> Job Title </th>
                                    <th> Educational Level </th>
                                    <th> Working Unit </th>
                                    <th> HR Branch </th>
                                    <th> Age(in years) </th>
                                    <th> Employed date</th>
    
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
    
    
                                @foreach ($employees_employeds as $employee)
                                    <tr>
    
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $employee->name ?? '-' }} </td>
                                        <td> {{ $employee->position->name ?? '-' }}</td>
                                        <td> {{ $employee->educationLevel->name ?? '-' }}</td>
                                        <td> {{ $employee->gender ?? ('-' ?? '-') }}</td>
                                        <td> {{ $employee->hrBranch->name ?? '-' }}</td>
                                        <td>
                                            <label for="" style="font-size:17px;"
                                                title=" GC: {{ \Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }} ">
    
    
    
                                                @if ($employee->age() > 58)
                                                    <span title="Retirement date is reach!" class="badge badge-pill badge-defualt">
                                                        {{ $employee->age() }} </span>
                                                @elseif ($employee->age() > 56)
                                                    <span title="Retirement date is reaching"
                                                        class="badge badge-pill badge-defualt"> {{ $employee->age() }} </span>
                                                @elseif ($employee->age() > 17)
                                                    <span title="Retirement date yet not reach!"
                                                        class="badge badge-pill badge-defualt"> {{ $employee->age() }} </span>
                                                @else
                                                    <span title="Inavide age! Less than 18 can be an employee"
                                                        class="badge badge-pill badge-defualt"> <del> Less 18 years old
                                                        </del></span>
                                            </label>
                                        </td>
                                @endif
    
    
    
                                <td style="color:red;"> {{ $employee->employement_date->format('d F Y', 'fr'); }}</td>
                                <td>
                                    <a href="{{ route('employee.edit', ['id' => $employee->id]) }}" title="Edit"
                                        class="btn  btn-sm btn-outline-primary float-right mr-1">
                                        <i class="fa fa-edit"> </i>
                                    </a>
                                    <a href="{{ route('employee', ['employee_id' => $employee->id]) }}" title="Profile"
                                        class="btn  btn-sm btn-outline-primary float-right mr-1">
                                        <i class="fa fa-user-tie"> </i>
                                    </a>
    
    
    
                                </td>
    
                                </tr>
                                @endforeach
                                @if (count($employees) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center"> No suspected errors found! </td>
                                    </tr>
                                @endif
    
                            </tbody>
    
                        </table>
                        <div class="m-auto float-right">
                            {{ $employees->links() }}
    
    
                        </div>
                    </div>
                </div>
            </div>

        </div>

     


            <!-- /////////////////////////////////////////////// -->
            <div class="row">
                <div class="col">
                   
                        <div class="collapse multi-collapse2" id="multiCollapseExample3">
                        <div class="card card-body">
    
                            <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> FullName</th>
                                        <th> Job Title </th>
                                        <th> Educational Level </th>
                                        <th> Working Unit </th>
                                        <th> HR Branch </th>
                                        <th> Age(in years) </th>
                                        <th> Job Code</th>
        
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
        
        
                                    @foreach ($employees as $employee)

                                    @if ($employee->positionCode?->code === null)
                                        <tr>
        
                                            <td> {{ $loop->index + 1 }} </td>
                                            <td> {{ $employee->name ?? '-' }} </td>
                                            <td> {{ $employee->position->name ?? '-' }}</td>
                                            <td> {{ $employee->educationLevel->name ?? '-' }}</td>
                                            <td> {{ $employee->gender ?? ('-' ?? '-') }}</td>
                                            <td> {{ $employee->hrBranch->name ?? '-' }}</td>
                                            <td>
                                                <label for="" style="font-size:17px;"
                                                    title=" GC: {{ \Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }} ">
        
        
        
                                                    @if ($employee->age() > 58)
                                                        <span title="Retirement date is reach!" class="badge badge-pill badge-danger">
                                                            {{ $employee->age() }} </span>
                                                    @elseif ($employee->age() > 56)
                                                        <span title="Retirement date is reaching"
                                                            class="badge badge-pill badge-warning"> {{ $employee->age() }} </span>
                                                    @elseif ($employee->age() > 17)
                                                        <span title="Retirement date yet not reach!"
                                                            class="badge badge-pill badge-defualt"> {{ $employee->age() }} </span>
                                                    @else
                                                        <span title="Inavide age! Less than 18 can be an employee"
                                                            class="badge badge-pill badge-defualt"> <del> Less 18 years old
                                                            </del></span>
                                                </label>
                                            </td>
                                    @endif
        
        
        
                                    <td> {{ $employee->positionCode?->code ?? ('-' ?? '-') }}</td>
                                    <td>
                                        <a href="{{ route('employee.edit', ['id' => $employee->id]) }}" title="Edit"
                                            class="btn  btn-sm btn-outline-primary float-right mr-1">
                                            <i class="fa fa-edit"> </i>
                                        </a>
                                        <a href="{{ route('employee', ['employee_id' => $employee->id]) }}" title="Profile"
                                            class="btn  btn-sm btn-outline-primary float-right mr-1">
                                            <i class="fa fa-user-tie"> </i>
                                        </a>
        
        
        
                                    </td>
        
                                    </tr>
                                    @endif
                                    @endforeach
                                    @if (count($employees) == 0)
                                        <tr>
                                            <td colspan="7" class="text-center"> No employee found! </td>
                                        </tr>
                                    @endif
        
                                </tbody>
        
                            </table>
                            <div class="m-auto float-right">
                                {{ $employees->links() }}
        
        
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>

        <!-- /////////////////////////////////////////////// -->
        <div class="row">
            <div class="col">
                <div class="collapse multi-collapse3" id="multiCollapseExample6">
                    <div class="card card-body">

                        <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> FullName</th>
                                    <th> Job Title </th>
                                    <th> Educational Level </th>
                                    <th> Working Unit </th>
                                    <th> HR Branch </th>
                                    <th> Age(in years) </th>
                                    <th> Job Code</th>
    
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
    
    
                                @foreach ($employee_ages as $employee)
                                    <tr>
    
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $employee->name ?? '-' }} </td>
                                        <td> {{ $employee->position->name ?? '-' }}</td>
                                        <td> {{ $employee->educationLevel->name ?? '-' }}</td>
                                        <td> {{ $employee->gender ?? ('-' ?? '-') }}</td>
                                        <td> {{ $employee->hrBranch->name ?? '-' }}</td>
                                        <td>
                                            <label for="" style="font-size:17px;"
                                                title=" GC: {{ \Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }} ">
    
    
    
                                                @if ($employee->age() > 58)
                                                    <span title="Retirement date is reach!" class="badge badge-pill badge-danger">
                                                        {{ $employee->age() }} </span>
                                                @elseif ($employee->age() > 56)
                                                    <span title="Retirement date is reaching"
                                                        class="badge badge-pill badge-warning"> {{ $employee->age() }} </span>
                                                @elseif ($employee->age() > 17)
                                                    <span title="Retirement date yet not reach!"
                                                        class="badge badge-pill badge-defualt"> {{ $employee->age() }} </span>
                                                @else
                                                    <span title="Inavide age! Less than 18 can be an employee"
                                                        class="badge badge-pill badge-defualt"> <del> Less 18 years old
                                                        </del></span>
                                            </label>
                                        </td>
                                @endif
    
    
    
                                <td> {{ $employee->positionCode?->code ?? ('-' ?? '-') }}</td>
                                <td>
                                    <a href="{{ route('employee.edit', ['id' => $employee->id]) }}" title="Edit"
                                        class="btn  btn-sm btn-outline-primary float-right mr-1">
                                        <i class="fa fa-edit"> </i>
                                    </a>
                                    <a href="{{ route('employee', ['employee_id' => $employee->id]) }}" title="Profile"
                                        class="btn  btn-sm btn-outline-primary float-right mr-1">
                                        <i class="fa fa-user-tie"> </i>
                                    </a>
    
    
    
                                </td>
    
                                </tr>
                                @endforeach
                                @if (count($employees) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center"> No employee found! </td>
                                    </tr>
                                @endif
    
                            </tbody>
    
                        </table>
                        <div class="m-auto float-right">
                            {{ $employees->links() }}
    
    
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- /////////////////////////////////////////////// -->

        </div>



       
    @endcan



@endsection
