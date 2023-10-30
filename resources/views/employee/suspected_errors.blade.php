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
                aria-controls="multiCollapseExample4 multiCollapseExample3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Job position erros</button>

            <button class="btn btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse3" aria-expanded="false"
                aria-controls="multiCollapseExample5 multiCollapseExample6"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Birth date errors </button>


            <button class="btn btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse4" aria-expanded="false"
                aria-controls="multiCollapseExample6 multiCollapseExample7"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Phone related Errors </button>

                <button class="btn btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse5" aria-expanded="false"
                aria-controls="multiCollapseExample7 multiCollapseExample8"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Internal Exp. date-range Errors </button>

                <button class="btn btn-sm btn-outline-danger mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse6" aria-expanded="false"
                aria-controls="multiCollapseExample9 multiCollapseExample10"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> External Exp. date-range Errors </button>

        </p>




          <!-- /////////////////////////////////////////////// -->
          <div class="row">
            <div class="col">
               
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">
                        <p> Errors discoveries related with date of employement  </p>
                        <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> FullName</th>
                                    <th> Job Title </th>
                                    <th> Unit </th>
                                    <th> HR Branch </th>
                                    <th> Age </th>
                                    <th> Employed date</th>
                                    <th> Issues found </th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
    
    
                                @foreach ($employees_employeds as $employee)
                                    <tr>
    
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $employee->name ?? '-' }} </td>
                                        <td> {{ $employee->position->name ?? '-' }}</td>
                                  
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
                                                    <span title="Inavide age! Less than 18 can be an employee" style="color:red;"
                                                        class="badge badge-pill badge-defualt"> 
                                                        {{ $employee->age() }}
                                                    </span>
                                            </label>
                                        </td>
                                @endif

                              

                                
                    <td > {{ (\Carbon\Carbon::parse($employee->employement_date))->format('d F Y') }} E.C</td>

      
                                <td style="color:red;"> {{ 'Higher years of Experience or Under probaion period' }}</td>
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
                                @if (count($employees_employeds) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center"> No suspected errors found! </td>
                                    </tr>
                                @endif
    
                            </tbody>
    
                        </table>
                       
                        
                    </div>
                    <div class="m-auto float-right">
                        {{ $employees_employeds->links() }}

                    </div>
                </div>
            </div>

        </div>

     


            <!-- /////////////////////////////////////////////// -->
            <div class="row">
                <div class="col">
                   
                        <div class="collapse multi-collapse2" id="multiCollapseExample3">
                        <div class="card card-body">
                            <p> Errors discoveries related with job position code </p>
                            <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> FullName</th>
                                        <th> Job Title </th>
                                   
                                        <th> Working Unit </th>
                                        <th> HR Branch </th>
                                        <th> Age(in years) </th>
                                        <th> Job Code</th>
                                        <th> Issues found </th>
        
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
        
        
                                    @foreach ($employees as $employee)

                                 
                                        <tr>
        
                                            <td> {{ $loop->index + 1 }} </td>
                                            <td> {{ $employee->name ?? '-' }} </td>
                                            <td> {{ $employee->position->name ?? '-' }}</td>
                                       
                                            <td> {{ $employee->gender ?? ('-' ?? '-') }}</td>
                                            <td> {{ $employee->hrBranch->name ?? '-' }}</td>
                                            <td>
                                                <label for="" style="font-size:17px;"
                                                    title=" GC: {{ \Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }} ">
        
                                                       @if($employee->age()> 60 or $employee->age() < 19 )
                                                    <span title="Inavide age! Less than 18 can be an employee" style="color:red;"
                                                    class="badge badge-pill badge-defualt"> 
                                                    {{ $employee->age() }}
                                                </span>
                                                @else
                                                <span title="" style="color:black;"
                                                class="badge badge-pill badge-defualt"> 
                                                {{ $employee->age() }}
                                            </span>
                                                @endif

                                                </label>
                                            </td>
                                
        
        
        
                                    <td> {{ $employee->positionCode?->code ?? ('-' ?? '-') }}</td>
                                    <td style="color:red;">{{ 'Empty position code' }}</td>
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
                                    <td> {{ '-' }}</td>
        
                                    </tr>
                              
                                    @endforeach
                                    @if (count($employees) == 0)
                                        <tr>
                                            <td colspan="7" class="text-center"> No errors found! </td>
                                        </tr>
                                    @endif
        
                                </tbody>
        
                            </table>
                          
                        </div>
                        <div class="m-auto float-right">
                            {{ $employees->links() }}
    
                        </div>
                    </div>
                </div>
    
            </div>

        <!-- /////////////////////////////////////////////// -->
        <div class="row">
            <div class="col">
                <div class="collapse multi-collapse3" id="multiCollapseExample6">
                    <div class="card card-body">
                        <p> Errors discoveries related with employee under-age(< 18) and passed retirement (> 60)</p>
                        <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> FullName</th>
                                    <th> Job Title </th>
                                    <th> Educational Level </th>
                                    <th> Working Unit </th>
                                    <th> HR Branch </th>
                                    <th> Invalid age </th>
                                    <th> Issues found </th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
    
    
                                @foreach ($employee_ages as $employee)

                                 @if($employee->date_of_birth != null)
                                @if ($employee->age() >= 61 or $employee->age() < 19)
                                    <tr>
    
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $employee->name ?? '-' }} </td>
                                        <td> {{ $employee->position->name ?? '-' }}</td>
                                        <td> {{ $employee->educationLevel->name ?? '-' }}</td>
                                        <td> {{ $employee->gender ?? ('-' ?? '-') }}</td>
                                        <td> {{ $employee->hrBranch->name ?? '-' }}</td>
                                        <td>
                                            <label for="" style="font-size:17px;" title="">
                                           <span title="Inavide age! Less than 18 can be an employee" style="color:red;"
                                                class="badge badge-pill badge-defualt"> 
                                                {{ $employee->age() }}
                                            </span>
                                            </label>
                                        </td>
                           
    
                                   <td style="color:red;">
                                   @if($employee->age() <= 18)

                                   {{ 'Less than 18 years old' }}
                                   @else
                                   {{ 'Retirment period is passed' }}
                                   @endif

                              
                                 </td>
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
                                @endif
                                @endforeach
                                @if (count($employee_ages) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center"> No errors found! </td>
                                    </tr>
                                @endif
    
                            </tbody>
    
                        </table>

                   
                    </div>
                    @foreach ($employee_ages as $employee)
                    @if($employee->date_of_birth != null)
                    <div class="m-auto float-right">
                        {{ $employee_ages->links() }}
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

        </div>

        <!-- /////////////////////////////////////////////// -->

        <div class="row">
            <div class="col">
                <div class="collapse multi-collapse4" id="multiCollapseExample7">
        
                    <div class="card card-body">
                       <p> Errors discoveries related with suplicated employee mobile number  </p>
                        <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> FullName</th>
                                    <th> Job Title </th>
                                    <th> Working Unit </th>
                                    <th> HR Branch </th>
                                    <th> Phone </th>
                                    <th> Issues found </th>
    
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
    
    

                            
                        
    @foreach ($employees_phone as $employee)

            <tr>
    
                <td> {{ $loop->index + 1 }} </td>
                <td> {{ $employee->name ?? '-' }} </td>
                <td> {{ $employee->position->name ?? '-' }}</td>
               
                <td> {{ $employee->gender ?? ('-' ?? '-') }}</td>
                <td> {{ $employee->hrBranch->name ?? '-' }}</td>
                <td>
                    <label for="" style="font-size:17px;"
                        title=" GC: {{ \Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }} ">



                    <span title="Duplicated phone" style="color:red;"
                        class="badge badge-pill badge-defualt"> 
                        {{ $employee->phone_number ?? '-' }}
                    </span>
                    </label>
                </td>
   

                <td style="color:red;"> 
                 
                    {{ 'Duplicated phone number' }}
                
                </td>
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
                     @if (count($employees_phone) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center"> No errors found! </td>
                                    </tr>
                     @endif
    
                            </tbody>
    
                        </table>
                       
                    </div>
                     {{-- <div class="m-auto float-right">
                            {{ $employees_phone->links() }}
    
    
                        </div> --}}
                </div>
            </div>

        </div>
        

         <!-- /////////////////////////////////////////////// -->
         <div class="row">
            <div class="col">
                <div class="collapse multi-collapse5" id="multiCollapseExample8">
        
                    <div class="card card-body">
                       <p> Errors discoveries related with internal experience's date range  </p>
                        <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> FullName</th>
                                    <th> Job Title </th>
                                    <th> Working Unit </th>
                                    <th> HR Branch </th>
                                    <th> No of Exp. </th>
                                    <th> Issues found </th>
    
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
    
    
                                <?php $count = 0; ?>

                                @foreach ($employees_internal as $employee)
                                
                              
                                        <tr>
                                
                                            <td> {{ $loop->index + 1 }} </td>
                                            <td> {{ $employee->name ?? '-' }} </td>
                                            <td> {{ $employee->position->name ?? '-' }}</td>
                                            <td> {{ $employee->gender ?? ('-' ?? '-') }}</td>
                                            <td> {{ $employee->hrBranch->name ?? '-' }}</td>
                                            <td>{{  $employee->internalExperiences->count() }}</td>
                                            @foreach ($employee->internalExperiences as $employee_exp )
                                                @if($employee_exp->start_date >=   $employee_exp->end_date)
                                                    <?php $count++; ?>
                                                @endif
                                
                                            @endforeach
                                
                                            <td style="color:red;">{{$count }} issue found, {{ 'Invalid date-range' }}</td>
                                
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

                                @if (count($employees_internal) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center"> No errors found! </td>
                                    </tr>
                                @endif
    
                            </tbody>
    
                        </table>
                    </div>
                    <div class="m-auto float-right">
                        {{ $employees_internal->links() }}


                    </div>
                </div>
            </div>

        </div>

         <!-- /////////////////////////////////////////////// -->
         <div class="row">
            <div class="col">
                <div class="collapse multi-collapse6" id="multiCollapseExample10">
        
                    <div class="card card-body">
                       <p> Errors discoveries related with external experience's date range  </p>
                        <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> FullName</th>
                                    <th> Job Title </th>
                                    <th> Working Unit </th>
                                    <th> HR Branch </th>
                                    <th> No of Exp. </th>
                                    <th> Issues found </th>
    
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
    
    
                                @foreach ($employees_external as $employee)

                                        <tr>
    
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $employee->name ?? '-' }} </td>
                                        <td> {{ $employee->position->name ?? '-' }}</td>
                                       
                                        <td> {{ $employee->gender ?? ('-' ?? '-') }}</td>
                                        <td> {{ $employee->hrBranch->name ?? '-' }}</td>
                                        <td>
                                           {{  $employee->externalExperiences->count() }}
                                        </td>
                           
                                       
                                        <?php $count = 0; ?>
                                @foreach ($employee->externalExperiences as $employee_exp)

                                @if($employee_exp->start_date >= $employee_exp->end_date)
                                        <?php $count++ ; ?>
                                        @endif
                                        @endforeach

                        <td style="color:red;">{{$count }} issue found, {{ 'Invalid date-range' }}</td>
                               
                        
                        
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
                                        <td colspan="7" class="text-center"> No errors found! </td>
                                    </tr>
                                @endif
    
                            </tbody>
    
                        </table>
                    </div>
                    <div class="m-auto float-right">
                        {{ $employees_external->links() }}


                    </div>
                </div>
            </div>

        </div>
        <!-- ///////////////////////////////////////////// -->
        </div>



       
    @endcan



@endsection
