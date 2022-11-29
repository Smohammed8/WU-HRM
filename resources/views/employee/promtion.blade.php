<!-- //////////////////////// Employee promotion Modal  ///////////////////////////// -->
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.min.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/calendar/css/redmond.calendars.picker.css') }}" />

<div class="modal fade modal-fullscreen" id="promotion" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"> Employee:<u>{{ $crud?->entry?->name }} </u>
                    &nbsp;&nbsp;&nbsp; Existing Unit:<u>{{ $crud?->entry->unit?->name }} </u> &nbsp;&nbsp;&nbsp;
                    Existing position: <u> {{ $crud?->entry?->jobTitle?->name }}</u> </h6>
                <div class="row">
                    <a class="btn  btn-sm btn-outline-primary float-right mr-1" data-toggle="collapse"
                        href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span aria-hidden="true"> <i class="la la-plus"></i> Add promotion </span>
                    </a>

                    <button type="button" class="btn  btn-sm btn-outline-primary pull-right mr-1" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true"> <i class="la la-times"></i> Close </span>
                    </button>

                </div>
            </div>
            <!-------- //////////////////////////// -->
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <!--- ////////////////////// leave form ----------->
                    <form action="{{ route('promotion.create', []) }}" method="GET">
                        @csrf

                        <input type="hidden" name="employee" value="{{ $crud->entry->id }}">
                        <div class="card">
                            <div class="card-body">



                                <div class="form-group col-sm-12 col-md-4">
                                    <label for=""><i class="la la-user"></i> New Office </label>
                                    <select name="misconduct_type" style="width:100%;" class="form-control select2"
                                        required="required">

                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group col-sm-12 col-md-4">
                                    <label for=""><i class="la la-user"></i> New Job Title</label>
                                    <select name="misconduct_type" style="width:100%;" class="form-control select2"
                                        required="required">

                                        @foreach ($jobe_titles as $jobe_title)
                                            <option value="{{ $jobe_title->id }}">{{ $jobe_title->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label for=""><i class="la la-user"></i> Promotion type</label>
                                    <select name="misconduct_type" style="width:100%;" class="form-control select2"
                                        required="required">
                                        <option value="">..................... </option>
                                        <option value="1"> Veritical </option>
                                        <option value="2"> Horizontal </option>
                                        <option value="3"> Veritical and Horizontal </option>
                                    </select>
                                </div>


                                <div class="form-group col-sm-12 col-md-4">
                                    <label for=""><i class="la la-user"></i> New Job grade</label>
                                    <select style="width:100%;" name="misconduct_type" class="form-control select2"
                                        required="required">
                                        <option value="">Select job grade </option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>





                                <div class="form-group col-sm-12 col-md-12">
                                    <label for=""><i class="la la-user"></i> What is the reason of
                                        {{ $crud->entry->name }}'s promotion?</label>
                                    <textarea type="text" required="required" cols="15" rows="5" class="form-control" name="comment"> </textarea>
                                </div>




                            </div>
                        </div>




                        <button type="submit" name="save" class="btn  btn-sm btn-primary float-right mr-1"> <i
                                class="la la-plus"> </i>Save </button>
                    </form>


                </div>
            </div>


            <div class="modal-body">

                <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                    cellspacing="0">

                    <thead>
                        <tr style="background-color: lightblue;">

                            <th> #</th>
                            <th> Old office</th>
                            <th> New office </th>
                            <th> Old Position</th>
                            <th> New position </th>

                            <th> Added date </th>
                            <th> Reason of promotion</th>

                            <th> Action</th>
                        </tr>
                    </thead>
                    <br>

                    <tbody>

                        @foreach ($promotions as $promotion)
                            <tr>


                                <td>{{ $loop->index + 1 }} </td>
                                <td>{{ $promotion->oldUnit->name }}</td>
                                <td>{{ $promotion->newUnit->name }}</td>
                                <td>{{ $promotion->oldJobTitle->name }}</td>
                                <td>{{ $promotion->newJobTitle->name }}</td>
                                {{-- <td>{{ $promotion->createdBy->name }}</td> --}}
                                <td>{{ Carbon\Carbon::parse($promotion->createdAt)->format('d, F Y') }} </td>
                                <td>{{ $promotion->reason_of_promotion }} </td>

                                <td>

                                    <button type="button" data-toggle="modal" data-target="#check-in"
                                        target="_top" class="btn  btn-sm btn-outline-primary float-right mr-1"> <i
                                            class="la la-print"></i> Print </button>
                                    <a href="" class="btn  btn-sm btn-outline-primary float-right mr-1"><i
                                            class="la la-edit"></i> Edit</a>

                                </td>
                            </tr>
                        @endforeach
                        @if (count($promotions) == 0)
                            <tr>
                                <td colspan="7" style="color:red;" class="text-center">No employee promotions!
                                </td>
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
<script>
    $('.js-example-basic-single').select2({
        placeholder: "Select...",
        allowClear: true,
        width: "100%"
    });
</script>
