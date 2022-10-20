<!-- //////////////////////// Eficieny Modal  ///////////////////////////// -->
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.min.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}" >
<link rel="stylesheet" href="{{ asset('assets/calendar/css/redmond.calendars.picker.css')}}"/>

<div class="modal fade modal-fullscreen" id="efficiency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
      <div class="modal-content">
        <div class="modal-header">
             <h6 class="modal-title" id="exampleModalLabel"> Employee: {{ $crud->entry->name }} </h6>





           <div class="row">


                <a class="btn  btn-sm btn-outline-primary float-right mr-1" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span aria-hidden="true"> <i class="la la-plus"></i> Add new </span>
                </a>

           <button type="button" class="btn  btn-sm btn-outline-primary pull-right mr-1" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">  <i class="la la-times"></i>  Close </span>
             </button>

<a href="javascript: window.print();" class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-print"></i> Print</a>


           </div>

        </div>


        <!-------- //////////////////////////// -->
          <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <!--- ////////////////////// Evalution form ----------->
                <form action="{{ route('employeeEvaluation.create', []) }}" method="GET">
                    @csrf


                    <table class="table table-hover" cellpadding="0" cellspacing="0">
                          <thead>

                            <tr style="background-color: lightblue">
                                <th>#</th>
                            <th>  Employee Evalution Criteria</th>
                            <th> Evaluation Levels  </th>

                          </tr>
                        </thead>

                        <tbody>

                            <input type="hidden" name="employee" value="{{$crud->entry->id }}">

                            @foreach ($evalutionCreterias as $evalutionCreteria)

                            {{-- <input type="hidden" name="evalution[]" value="{{  $evalutionCreteria->id }}"> --}}


                                <tr>
                                    <td> {{$loop->index+1}}  </td>
                                    <td>
                                        <input  name="criteria[]" type="hidden" value="{{ $evalutionCreteria->id }}" />

                                        {{  $evalutionCreteria->name }} [ {{  $evalutionCreteria->percent}}]</td>

                                    <td>
                                        <select class="select2" name="level{{ $evalutionCreteria->id }}[]" required>
                                            <option value=""> Select evaluation mark..   </option>
                                            <option value="4"> Excellent[4] </option>
                                            <option value="3"> Very Good[3] </option>
                                            <option value="2"> Good[2] </option>
                                            <option value="1"> Poor[1] </option>



                                        </select>

                                        {{-- <input name="level{{ $evalutionCreteria->id }}[]"  type="radio" value="4"  required />  Excellent(4) &nbsp;
                                        <input name="level{{ $evalutionCreteria->id }}[]"  type="radio" value="3" required />  Very good(3)  &nbsp;
                                        <input name="level{{ $evalutionCreteria->id }}[]"  type="radio" value="2"  required />  Good(2)  &nbsp;
                                        <input name="level{{ $evalutionCreteria->id }}[]"  type="radio" value="1"  required />  Poor(1)  &nbsp; --}}

                                    </td>

                                </tr>
                         @endforeach
                            @if(count($employeeEvaluations)==0)
                                <tr>
                                    <td colspan="7" class="text-center">No evaluations found! </td>
                                </tr>
                            @endif
                            </tbody>

                            </table>
                    <button type="submit" name="save" class="btn  btn-sm btn-primary float-right mr-1"> <i class="la la-plus"> </i>Save </button>
                    </form>


            </div>
          </div>

<!-- ///////////////////////////////////////////////--->
        <div class="modal-body">


                <table id="crudTable" class="bg-white table table-sm table-hover nowrap rounded shadow-xs mt-2" cellspacing="0">
                <thead>
                  <tr style="background-color: lightblue;">

                    <th> #</th>
                    <th> Evalution Criteria</th>
                    <th> Evalution level </th>
                    <th>Recorded by</th>
                    <th>Obtained Mark</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>

                    @foreach ($employeeEvaluations as $employeeEvaluation)
                        <tr >

                            <td> {{$loop->index+1}}  </td>
                            <td >{{  $employeeEvaluation->evalutionCreteria->name }}( {{ $employeeEvaluation->evalutionCreteria->percent }})</td>
                            <td>{{ $employeeEvaluation->evaluationLevel->name }}({{ $employeeEvaluation->evaluationLevel->weight }})</td>
                            <td>{{ 'Hailu Chamir' }}</td>
                            <td>{{ $employeeEvaluation->evaluationLevel->weight * $employeeEvaluation->evalutionCreteria->percent }} </td>
                            <td>{{   $employeeEvaluation->created_at }}</td>



                            <td>
                                <a href="" class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>

                            </td>
                        </tr>
                 @endforeach
                    @if(count($employeeEvaluations)==0)
                        <tr>
                            <td colspan="7" class="text-center">No employee evaluation found</td>
                        </tr>
                    @endif
                </tbody>
              </table>

              {{-- <ul class="pagination">
                {{ $employeeEvaluations->links() }}
            </ul> --}}


        </div>


      </div>
    </div>
  </div>
<!---- //////////////////////////////////////////////////////////// -->
