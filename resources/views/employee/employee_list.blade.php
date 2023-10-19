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

        <p>

            <button class="btn  btn-sm btn-outline-primary mr-1" type="button" data-toggle="collapse" data-target=".multi-collapse"
                aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2"> <i class="fa fa-list"></i>
                Analytics on Administrative Staff for {{ $name }} </button>

            <button class="btn btn-sm btn-outline-primary mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse2" aria-expanded="false"
                aria-controls="multiCollapseExample4 multiCollapseExample3"><i class="fa fa-list"></i> Analytics on Academic
                Staff for {{ $name }} </button>

            <button class="btn btn-sm btn-outline-primary mr-1" type="button" data-toggle="collapse"
                data-target=".multi-collapse3" aria-expanded="false"
                aria-controls="multiCollapseExample5 multiCollapseExample6"><i class="fa fa-download-alt"></i> Export Employee
                from {{ $name }} </button>

        </p>
        <div class="row">
            <div class="col">

                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">
                        <?php
                        
                        $male_count = 0;
                        $female_count = 0;
                        
                        ?>

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    Number of Administrative Staff on Duty by Educational Level at {{ $name }}
                                </tr>
                                <hr>
                            </thead>
                            <thead>

                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Education Level</th>
                                    <th scope="col">Male</th>
                                    <th scope="col">Female</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($educations as $education)
                                    <tr>

                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $education->name ?? '-' }} </td>
                                        <td> {{ $education->male_count }}</td>
                                        <td> {{ $education->female_count }} </td>
                                        <td> {{ $education->male_count + $education->female_count }}</td>



                                    </tr>

                                    <?php $male_count += $education->male_count; ?>
                                    <?php $female_count += $education->female_count; ?>
                                @endforeach
                            </tbody>


                            <tfoot>
                                <tr style="background-color:lightblue;">
                                    <td colspan="2"> Grand Total</td>
                                    <td> <u>{{ $male_count }} </u></td>
                                    <td> <u>{{ $female_count }} </u></td>
                                    <td> <u>{{ $male_count + $female_count }} </u></td>

                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">


                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    Number of Employee by Current Employement Status at {{ $name }}
                                </tr>
                                <hr>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> Employment status</th>
                                    <th scope="col">Male</th>
                                    <th scope="col">Female</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employmentStatuses as $employmentStatus)
                                    <tr>

                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $employmentStatus->name ?? '-' }} </td>
                                        <td> {{ $employmentStatus->male_status_count }}</td>
                                        <td> {{ $employmentStatus->female_status_count }} </td>
                                        <td> {{ $employmentStatus->male_status_count + $employmentStatus->female_status_count }}
                                        </td>



                                    </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr style="background-color:lightblue;">
                                    <td colspan="2"> Grand Total</td>
                                    <td> <u>{{ '-' }} </u></td>
                                    <td> <u>{{ '-' }} </u></td>
                                    <td> <u>{{ '-' }} </u></td>

                                </tr>
                            </tfoot>
                        </table>




                    </div>
                </div>
                <!---- sencond div -->
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">
                        <?php $male_hr_count = 0; ?>
                        <?php $female_hr_count = 0; ?>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    Number of employee by Branch Offices at University Level
                                </tr>
                                <hr>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">HR Office</th>
                                    <th scope="col">Male</th>
                                    <th scope="col">Female</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                    <tr>
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $branch->name ?? '-' }} </td>
                                        <td> {{ $branch->male_hr_count }}</td>
                                        <td> {{ $branch->female_hr_count }} </td>
                                        <td> {{ $branch->male_hr_count + $branch->female_hr_count }}</td>
                                    </tr>
                                @endforeach


                            </tbody>



                            @foreach ($branches as $branch)
                                <?php $male_hr_count += $branch->male_hr_count; ?>
                                <?php $female_hr_count += $branch->female_hr_count; ?>
                            @endforeach


                            <tfoot>
                                <tr style="background-color:lightblue;">
                                    <td colspan="2"> Grand Total</td>
                                    <td> <u>{{ $male_hr_count }} </u></td>
                                    <td> <u>{{ $female_hr_count }} </u></td>
                                    <td> <u>{{ $male_hr_count + $female_hr_count }} </u></td>

                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
                <!-- ///////////////////////// -->
            </div>


        </div>

      
        
        <!-- ////////////////////////////////////////// -->
        <div class="row">
            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">


                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    Number of Administrative Staff by Type of Employment at {{ $name }}
                                </tr>
                                <hr>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Employement type</th>
                                    <th scope="col">Male</th>
                                    <th scope="col">Female</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employements as $employement)
                                    <tr>

                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ $employement->name ?? '-' }} </td>
                                        <td> {{ $employement->type_male_count }}</td>
                                        <td> {{ $employement->type_female_count }}</td>
                                        <td> {{ $employement->type_male_count + $employement->type_female_count }}</td>



                                    </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr style="background-color:lightblue;">
                                    <td colspan="2"> Grand Total</td>
                                    <td> <u>{{ '-' }} </u></td>
                                    <td> <u>{{ '-' }} </u></td>
                                    <td> <u>{{ '-' }} </u></td>

                                </tr>
                            </tfoot>
                        </table>

                      
                    </div>
                </div>
            </div>

  
            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">
                        <?php
                        
                        $female_count = 0;
                        $male_count = 0;
                        
                        ?>

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    Number of Employee by Age classification
                                </tr>
                                <hr>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Age range</th>
                                    <th scope="col">Male</th>
                                    <th scope="col">Female</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($employmentStatuses as $employmentStatus) --}}
                                    <tr><td> 1 </td> <td> 18 - 30 </td> <td> - </td> <td> - </td> <td> - </td>  <td> 15%</td></tr>
                                    <tr><td> 2 </td><td> 31 - 40 </td> <td> - </td> <td> - </td> <td> - </td>  <td>  45% </td></tr>
                                    <tr><td> 3 </td><td> {{ '41 -50' }}</td> <td> - </td> <td> - </td> <td> - </td>  <td> 20%</td></tr>
                                    <tr><td> 4 </td><td> {{ ' 51 -60' }} </td> <td> - </td> <td> - </td>  <td> - </td>  <td>  20%</td></tr>
                                  
                        
                                {{-- @endforeach --}}
                        
                        
                            </tbody>
                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ///////////////////////////////////////////////// -->
        <div class="row">

            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">


                        <?php
                        
                        $female_category_count = 0;
                        $male_category_count = 0;
                        
                        ?>

                        <table class="table table-sm">

                            <thead>
                                <tr>
                                    Number of employee by Employee Category at {{ $name }}
                                </tr>
                                <hr>
                            </thead>


                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Employee Category</th>
                                    <th scope="col">Male</th>
                                    <th scope="col">Female</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $category->name ?? '-' }}</td>
                                        <td>{{ $category->male_category_count }}</td>
                                        <td>{{ $category->female_category_count }}</td>
                                        <td>{{ $category->male_category_count + $category->female_category_count }}</td>
                                    </tr>
                                    <?php $male_category_count += $category->male_category_count; ?>
                                    <?php $female_category_count += $category->female_category_count; ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background-color:lightblue;">
                                    <td colspan="2">&nbsp;&nbsp;&nbsp;Grand Total</td>
                                    <td><u>{{ $male_category_count }}</u></td>
                                    <td><u>{{ $female_category_count }}</u></td>
                                    <td><u>{{ $male_category_count + $female_category_count }}</u></td>
                                </tr>
                            </tfoot>
                        </table>


                    </div>
                </div>     
            </div>


            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                    <div class="card card-body">
                    
                       -
                    </div>
                </div>
            </div>
        </div>

        <!-- ///////////////////////////////////////////////// -->
        <div class="row">
            <div class="col">
                <div class="collapse multi-collapse2" id="multiCollapseExample3">
                    <div class="card card-body">
                        <?php
                        $female_category_count = 0;
                        $male_category_count = 0; ?>
                        <!-- add table here -->
                        -
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="collapse multi-collapse2" id="multiCollapseExample3">
                    <div class="card card-body">
                        <?php $male_hr_count = 0; ?>
                        <?php $female_hr_count = 0; ?>
                        <!-- add table here -->
                        -
                    </div>
                </div>
            </div>
        </div>

        <!-- /////////////////////////////////////////////// -->
        <div class="row">
            <div class="col">
                <div class="collapse multi-collapse3" id="multiCollapseExample6">
                    <div class="card card-body">

                        <?php
                        $branch_id = request()->segment(1);
                        
                        if (!is_numeric($branch_id)) {
                            abort(404); // For example, you can return a 404 error if the value is invalid
                        }
                        
                        //dd($branch_id);
                        
                        ?>
                        <form class="form-inline" action="{{ route('export-employees') }}" method="GET">
                            <div class="form-group mb-2">
                                <label for="staticEmail2" class="sr-only">Export Employee with CSV</label>
                                Export Employee with CSV
                            </div>
                            <div class="form-group mx-sm-3 mb-2">

                                <select class="form-control select2" name="hr_office" aria-label="Default select example">
                                    <option selected>----------HR Office----------</option>

                                    @foreach ($branches as $branch)
                                        <option value=" {{ $branch->id }} "> {{ $branch->name }} </option>
                                    @endforeach
                                </select>


                                <select class="form-control select2 mr-1" name="employee_category"
                                    aria-label="Default select example">
                                    <option selected> -----Employee Category----</option>

                                    @foreach ($categories as $category)
                                        <option value=" {{ $category->id }} "> {{ $category->name }} </option>
                                    @endforeach
                                </select>

                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Export</button>
                            {{-- <a class="btn btn-primary mb-2" href="{{ route('export-employees') }}" class="btn btn-success">Export Employees</a> --}}
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- /////////////////////////////////////////////// -->

        </div>



        <div class="card card-primary card-outline">

            {{-- <div class="card"> --}}

            <div class="card-header">
                <h5 class="mb-2"> List of an employees under :<u><b> {{ $name }} </b></u> </h5>
            </div> <!-- /.card-body -->
            <div class="card-body">
                <div class="container-fluid animated fadeIn">


                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"> <a href="{{ route('employee.index', []) }}"
                                        title=""> <i class="fa fa-male"></i></a></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"> <a href="{{ route('result') }}"> Male </a> </span>
                                    <span class="info-box-number"> {{ $males }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fa fa-female"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"> <a href=""> Female </a></span>
                                    <span class="info-box-number">{{ $females }} </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fa fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"> <a href="{{ backpack_url('position') }}"> Total Employees
                                        </a></span>
                                    <span class="info-box-number">{{ $total }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fa fa-list"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text"> <a href="{{ backpack_url('position') }}">Avaliable Positions
                                        </a></span>
                                    <span class="info-box-number"> {{ '-' }} </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


                    @push('css')
                        <style>
                            .select2,
                            .select2-container,
                            .select2-container--default,
                            .select2-container--below {
                                width: 100% !important;
                            }
                        </style>
                    @endpush


                    <script>
                        $(document).ready(function() {
                            $('#position').select2({});

                        });
                        $(document).ready(function() {
                            $('#unit').select2({});

                        });
                    </script>





                    <hr>
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
                <!-- /.container-fluid -->

                <!-- /.content -->



            </div>
            <hr>





        </div>
    @endcan



@endsection
