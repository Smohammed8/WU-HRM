<!-- //////////////////////// Employee decipline Modal  ///////////////////////////// -->
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.min.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}" >
<link rel="stylesheet" href="{{ asset('assets/calendar/css/redmond.calendars.picker.css')}}"/>
<div class="modal fade modal-fullscreen" id="decipline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
      <div class="modal-content">
        <div class="modal-header">
             <h6 class="modal-title" id="exampleModalLabel"> Employee: {{ $crud->entry->name }} </h6>
           <div class="row">
                <a class="btn  btn-sm btn-outline-primary float-right mr-1" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span aria-hidden="true"> <i class="la la-plus"></i> Add  misconduct </span>
                </a>

           <button type="button" class="btn  btn-sm btn-outline-primary pull-right mr-1" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">  <i class="la la-times"></i>  Close </span>
             </button>

           </div>
        </div>
        <!-------- //////////////////////////// -->
          <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <!--- ////////////////////// leave form ----------->
                <form action="{{ route('misconduct.create', []) }}" method="GET">
                    @csrf

                    <input type="hidden" name="employee" value="{{$crud->entry->id }}">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group col-sm-12 col-md-4">
                                <label for=""><i class="la la-user"></i>  Misconduct type</label>
                                <select name="misconduct_type" style="width:100%;"  class="form-control select2" required="required">
                                    <option value="">..................... </option>
                                    @foreach ($type_of_misconducts as $type_of_misconduct)
                                        <option value="{{ $type_of_misconduct->id }}">{{ $type_of_misconduct->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-sm-12 col-md-4">
                                <label for=""><i class="la la-user"></i> Severity</label>
                                <select name="severity" style="width:100%;"  id="severity" class="form-control select2" required="required">
                                    <option value="">Select serverity </option>

                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-12 col-md-4">
                                <label for=""><i class="la la-download"></i>  File upload </label>
                              <input type="file" class="form-control" name="file">
                            </div>



                            <div class="form-group col-sm-12 col-md-12">
                                <label for=""><i class="la la-user"></i> Could you tell us the misceonductivity of {{$crud->entry->name}}?</label>
                                <textarea type="text"  required="required" cols="15" rows="5" class="form-control" name="comment"> </textarea>
                              </div>




                        </div>
                    </div>




                    <button type="submit" name="save" class="btn  btn-sm btn-primary float-right mr-1"> <i class="la la-plus"> </i>Save </button>
                    </form>


            </div>
          </div>


        <div class="modal-body">

                <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2" cellspacing="0">

                <thead>
                  <tr style="background-color: lightblue;">

                    <th> #</th>
                    <th> Type of misconduct</th>
                    <th> Created by </th>
                    <th> Date of added</th>
                    <th> Attacement </th>
                    <th> Action taken </th>
                    <th> Serverity </th>

                    <th> Action</th>
                  </tr>
                </thead>
                <br>

                <tbody>

                    @foreach ($misconducts as $misconduct)
                        <tr>


                            <td>{{ $loop->index+1  }}  </td>
                            <td>{{ $misconduct->typeOfMisconduct->name }}</td>
                            <td>{{ $misconduct->createdBy->name }}</td>
                            <td>{{ Carbon\Carbon::parse($misconduct->createdAt )->format('d, F Y') }} </td>
                            <td>{{ $misconduct->attachement  }} </td>

                            @if($misconduct->action_taken !=null)
                            <td> Action taken</td>

                            @else
                            <td> {{ 'No' }} </td>
                            @endif
                            <td> {{ $misconduct->serverity  }} </td>
                            <td>
                                <button type="button"  data-toggle="modal" data-target="#check-in"  target="_top" class="btn  btn-sm btn-outline-primary float-right mr-1"> <i class="la la-user"></i> View </button>
                                <button type="button"  data-toggle="modal" data-target="#check-in"  target="_top" class="btn  btn-sm btn-outline-primary float-right mr-1"> <i class="la la-print"></i> Print </button>
                                <a href="" class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-edit"></i> Edit</a>
                             <a href="" class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-plus"></i> Add action</a>
                            </td>
                        </tr>

                 @endforeach
                    @if(count($misconducts)==0)
                        <tr>
                            <td colspan="7"  style="color:red;" class="text-center">No employee has misconducts!</td>
                        </tr>
                    @endif
                </tbody>
              </table>

              {{-- <ul class="pagination">
                {{ $leaves->links() }}
            </ul> --}}



        </div>



      </div>
    </div>
  </div>
