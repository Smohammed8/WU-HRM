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
            <h5 class="mb-2"> Placement result Analysis: Round -1 </h5>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="container-fluid animated fadeIn">


                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                           <span class="info-box-icon bg-info"> <a href="{{ route('employee.index', []) }}" title="">  <i class="fa fa-users"></i></a></span>

                            <div class="info-box-content">
                                <span class="info-box-text"> <a href ="{{route('result') }}"> Total placement  </a> </span>
                                <span class="info-box-number"> {{ $placements }}</span>
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
                                <span class="info-box-text"> <a href =""> Total unplaced Employee  </a></span>
                                <span class="info-box-number">-</span>
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
                                <span class="info-box-text">  <a href ="{{ backpack_url('position') }}"> Total positions  </a></span>
                                <span class="info-box-number">{{   $totalPositions }}</span>
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
                                <span class="info-box-text"> <a href ="{{ backpack_url('position') }}">Avaliable Positions  </a></span>
                                <span class="info-box-number"> {{ $totalPositions - $placements }} </span>
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
             
              $( document ).ready(function() {
                  $('#position').select2({
                  });
      
              });
              $( document ).ready(function() {
                  $('#unit').select2({
                  });
      
              });
      
          </script>


<div class="row">
    <div class="col-xs-6">
        <form action="{{ route('PlacementChoice.details') }}" method="GET">
            @csrf
            <div class="form-group">
                <select name="unit" id="unit"  required="required" class="form-control select2">
                    <option value=""> -  </option> 
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}"> {{ $unit->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-6">
            <div class="form-group">
                <select name="position"  required="required" class="form-control select2">
                    <option value="">Select  position </option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}"> {{ $position->jobTitle->name }} at {{ $position->unit->name }}  </option>
                    @endforeach
                </select>
            </div>

    </div>
 &nbsp; &nbsp; &nbsp;
    <div class="col-xs-1">
        <div class="form-group">
            <button type="submit" name="save" class="btn btn-sm btn-primary btn-float-right mr-1"> <i
                class="fa fa-search"> </i>Filter</button>
            </div>
    </div>

    
    <div class="col-xs-1">
    <div class="form-group">
        <button style="float: right;" type="submit" name="save" class="btn btn-sm btn-primary btn-float-right mr-1"> <i
            class="fa fa-download"> </i> Export </button>
        </div>
    </div>
    <div>

  </div>


    
        <hr>
s    <table class="table table-hover" cellpadding="0" cellspacing="0" style="font-size: 14px;"> 
            <thead>
                <tr style="background-color: lightblue">
                    <th>#</th>
                    <th> Employee</th>
                    <th>Employee Choices  </th>
             
                    <th> Employee Ranks </th>
              

                    <th> Employee Results[ % ]</th>
                
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
                        
                        
                            <td> {{ $placement_result->newPosition->jobTitle->name ?? '-' }}  at <u>{{ $placement_result->newPosition->unit->name ?? '-' }} </u> </td>
                        

                        

                        <td>

                            @if(is_null($placement_result->newPosition?->jobTitle->id))

                            <a href="#" title="No placed" class="btn btn-sm btn-primary float-right">
                                <i class="fa fa-list">  </i> 
                            </a> 

                            @else  
                         
                            <a href="{{ route('PlacementChoice.details', ['new_position_id'=> $placement_result->newPosition?? null  ]) }}" title="Make analysis" class="btn btn-sm btn-primary float-right">
                                <i class="fa fa-list">  </i> 
                            </a> 

                         @endif 
                    
                               
                          
                                  {{-- 
                            <form method="GET" action="{{ route('details',[]) }}">

                                    @csrf

                                <input type="hidden" value="{{ $placement_result->newPosition->jobTitle->id ?? null }}" name="newposition">

                                <button title="Make analysis"  name="filter" class="btn btn-sm btn-primary float-right">
                               <span class="fa fa-list"></span>
                              </button>

                            </form> --}}
                        
                            {{-- {{ route('payrollSheet.payee', ['payroll_sheet_id'=> $payroll_sheet->id]) }} --}}

                          
                        </td>
                        
                    </tr>
                @endforeach
                @if (count($placement_results) == 0)
                <tr>
                    <td colspan="7" class="text-center"> No placement found! </td>
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
