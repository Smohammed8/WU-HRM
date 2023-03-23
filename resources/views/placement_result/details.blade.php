@extends(backpack_view('blank'))


@section('content')
    @cannot('dashboard.content')
        <h3 class="text-center">Welcome to {{ env('APP_NAME') }}</h3>
    @endcan
    @can('dashboard.content')

    <br>    
     <div class="card card-primary card-outline"> 
        
      {{-- <div class="card"> --}}

        <div class="card-header">
            <h5 class="mb-2"> Placement result Analysis: Round -1 </h5>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="container-fluid animated fadeIn">


                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                           <span class="info-box-icon bg-info"> <a href="#" title="">  <i class="fa fa-users"></i></a></span>

                            <div class="info-box-content">
                                <span class="info-box-text"> <a href ="#"> No of candidates </a> </span>
                                <span class="info-box-number"> {{  $placement_results->count() }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-user-minus"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text"> <a href ="#"> No of positions </a></span>
                                <span class="info-box-number">2</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-flag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">  <a href ="#"> Min Educational Req. </a></span>
                                <span class="info-box-number">{{  'Batchor Degree'}}</span>
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
                                <span class="info-box-text"> <a href ="#"> Min Experience Req.  </a></span>
                                <span class="info-box-number"> {{ '7 years of Experience' }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- =========================================================== -->
                <div class="row ">

               
               
                  <div class="form-group col-10">
                        <h4> 
                      Candidates for the position of : <U>{{ $new_position   }} </U>
                     </h4>
                 </div>

                
                    

                    <div class="form-group col-1">
                        <button type="submit" name="save" class="btn btn-sm btn-primary float-right "> <i
                            class="fa fa-download"> </i> Print </button>
                        </div>

                 
                    
                       <div class="form-group col-1">
                   

                     <a href="{{ route('result') }}" title="Close" class="btn btn-sm btn-primary float-right">
                        <i class="fa fa-list">  </i> Back
                    </a>

                        </div>

                    <div>
                       

            <hr>
            

        </div><!-- /.card-body -->

        <table class="table table-hover" width="100" cellpadding="0" cellspacing="0" style="font-size: 12px;"> 
            <thead>
                <tr style="background-color: lightblue">
                    <th>#</th>
                    <th> Employee</th>
                    <th>Employee Choices  </th>
             
                    <th> Employee Ranks </th>
              

                    <th> Empoyee Results[ % ]</th>

                    <th> New position </th>
                
                 
                    <th> Action</th>
                </tr>
            </thead>
            <tbody>
              
              
                @foreach ($placement_results as $placement_result) 
                    <tr>

                        <td> {{ $loop->index + 1 }} </td>

                      
                            {{-- <input name="criteria[]" type="hidden" value="{{ $evalutionCreteria->id }}" /> --}}

                            <td> {{ $placement_result->employee->name ?? '-' }} </td>
                            <td> [  {{ $placement_result->choiceOne->name ?? '-'  }} at <u>{{ $placement_result->choiceOne->unit->name  ?? '-'}}</u> , {{ $placement_result->choiceTwo->name ?? '-'  }}  at <u>{{ $placement_result->choiceOne->unit->name ?? '-' }} </u> ]</td> 
                        

                            <td>[ {{ $placement_result->choice_one_rank ?? '-'  }}, {{ $placement_result->choice_two_rank ?? '-'  }}  ] </td>
                         

                            <td>[ {{ $placement_result->choice_one_result ?? '-' }}  , {{ $placement_result->choice_two_result ?? '-' }}  ]</td>
                        
                        
                        
                            <td> {{ $placement_result->newPosition->jobTitle->name ?? '-' }} </td>
                        
                        


                        <td  width="20%">
                          
                            <a href="{{ route('employee', ['employee_id'=>$placement_result->employee->id]) }}" title="Make analysis" class="btn btn-sm btn-primary float-right">
                                <i class="fa fa-user">  </i> Profile
                            </a>


                    
                                   
                          
                        </td>
                        
                    </tr>
                @endforeach
                @if (count($placement_results) == 0)
                <tr>
                    <td colspan="7" class="text-center">No placement found! </td>
                </tr>
            @endif
              
            </tbody>

        </table>
        <div class="m-auto col-6 mt-3">
            {{-- {{ $placement_results->withQueryString()->links() }} --}}
            {{-- {{ $placement_results->links() }} --}}
        </div>
      </div>
<!-- /.container-fluid -->

  <!-- /.content -->



    </div>
    <hr>


         

         
        </div>

    @endcan

   

@endsection
