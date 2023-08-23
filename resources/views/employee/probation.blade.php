@extends(backpack_view('blank'))


<style>

    body{
font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
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
     <div class="card card-primary card-outline"> 
        
      {{-- <div class="card"> --}}

        <div class="card-header">
            <h5 class="mb-2"> Employees under probation period </h5>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="container-fluid animated fadeIn">


                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                           <span class="info-box-icon bg-info"> <a href="#" title="">  <i class="fa fa-male"></i></a></span>

                            <div class="info-box-content">
                                <span class="info-box-text"> <a href ="#"> Male </a> </span>
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
                                <span class="info-box-text"> <a href =""> Female  </a></span>
                                <span class="info-box-number">{{ $females }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-user-tie"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">  <a href ="#"> Contracts  </a></span>
                                <span class="info-box-number">{{   $contracts }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text"> <a href ="#"> Permanents </a> </a></span>
                                <span class="info-box-number"> {{ $permanets }} </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

             
     



    
        <hr>
    <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;"> 
            <thead>
                <tr>
                    <th>#</th>
                    <th> Employee</th>
                    <th> Gender  </th>
             
                    <th> Working unit </th>
              

                    <th> Job title</th>
                    <th> Employee type </th>
                
                    <th> Duration  </th>
                    <th> Action</th>
                </tr>
            </thead>
            <tbody>
              
              
                @foreach ($employees as $employee) 
                    <tr>

                        <td> {{ $loop->index + 1 }} </td>

                      
                            <td> {{ $employee->name }} </td>
                    

                            <td>{{  $employee->gender }}   </td>
                         
                            <td> {{ $employee->position->unit->name }} </td>
                        
                        
                            <td> {{ $employee->position->jobTitle->name ?? '-' }} - {{ $employee->positionCode?->code ?? '-'  }} </td>

                            <td> {{ $employee->employeeCategory->name ?? '-' }} </td>
                            <td> {{ \Carbon\Carbon::parse($employee->employement_date)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }}</td>
                        

                        

                    
                        <td>

                         
                         
                            <a href="{{ route('employee', ['employee_id'=>$employee->id]) }}" title="Make analysis" class="btn btn-sm btn-primary float-right">
                                <i class="fa fa-user">  </i>  Profile
                            </a> 

                      
                               
        
                          
                        </td>
                        
                    </tr>
                @endforeach
                @if (count($employees) == 0)
                <tr>
                    <td colspan="7" class="text-center"> No employee found in probation period! </td>
                </tr>
            @endif
              
            </tbody>

        </table>
        <div class="m-auto col-6 mt-3 float-right">
            {{ $employees->withQueryString()->links() }} 
            {{-- {{ $employees->links() }} --}}
        </div>
      </div>
<!-- /.container-fluid -->

  <!-- /.content -->



    </div>
    <hr>


         

         
        </div>

    @endcan

   

@endsection
