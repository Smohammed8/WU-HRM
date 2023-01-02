<div class="modal fade modal-fullscreen" id="employee_leave" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"> Employee: {{ $crud->entry->name }} </h6>
                <div class="row">
                    @canany(['employee.leave.icrud', 'employee.leave.create'])
                        <a class="btn  btn-sm btn-outline-primary float-right mr-1" data-toggle="collapse"
                            href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span aria-hidden="true"> <i class="la la-user-minus"></i> Add leave </span>
                        </a>
                    @endcanany
                    <button type="button" class="btn  btn-sm btn-outline-primary pull-right mr-1" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true"> <i class="la la-times"></i> Close </span>
                    </button>

                </div>
            </div>
            <!-------- //////////////////////////// -->
            @canany(['employee.leave.icrud', 'employee.leave.create'])

            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <!--- ////////////////////// leave form ----------->
                    <form action="{{ route('leave.create', []) }}" method="GET">
                        @csrf

                        <input type="hidden" name="employee" value="{{ $crud->entry->id }}">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group col-sm-12 col-md-4">
                                    <label for=""><i class="la la-user"></i> Why an employee shall be
                                        leave?</label>
                                    <select name="leave_type" style="width:100%;" id="leave"
                                        class="form-control select2" required="required">
                                        <option value="">Select leave type </option>
                                        @foreach ($type_of_leaves as $type_of_leave)
                                            <option value="{{ $type_of_leave->id }}">{{ $type_of_leave->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for=""><i class="la la-calendar"></i> Leave date </label>
                                    <input type="text" id="start" autocomplete="off" class="form-control"
                                        name="ldate" required />
                                </div>

                                <div class="form-group col-sm-12 col-md-4">
                                    <label for=""><i class="la la-user-minus"></i> Total duration upon
                                        leave-out(in days)</label>
                                    <input type="number" min="1" max="724" class=" form-control"
                                        name="days" required>
                                </div>

                                <div class="form-group col-sm-12 col-md-12">
                                    <label for=""><i class="la la-envelope"></i> Do you have comment?</label>
                                    <textarea type="text" required="required" cols="15" rows="5" class="form-control" name="comment"> </textarea>
                                </div>




                            </div>
                        </div>




                        <button type="submit" name="save" class="btn  btn-sm btn-primary float-right mr-1"> <i
                                class="la la-plus"> </i>Save </button>
                    </form>


                </div>
            </div>
            @endcanany
            <!-- /////////////////////////////////////////////// -->

            <!-- ///////////////////////////////////////////////--->
            <div class="modal-body">

                {{-- <table class="table table-hover table-sm" cellpadding="0" cellspacing="0"> --}}
                <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                    cellspacing="0">

                    <thead>
                        <tr style="background-color: lightblue;">

                            <th> #</th>
                            <th> Reason for leave </th>
                            <th> Permitted by </th>
                            <th> Date of leave </th>
                            <th> Due date </th>
                            <th> Remaining time </th>
                            <th> Current status </th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <br>

                    <tbody>

                        @foreach ($leaves as $leave)
                            <tr>


                                <td>{{ $loop->index + 1 }} </td>
                                <td>{{ $leave->typeOfLeave->name }}</td>
                                <td>{{ $leave->createdBy->name }}</td>
                                <td>{{ Carbon\Carbon::parse($leave->leave_date)->format('d, F Y') }} </td>
                                <td>{{ $leave->due_date->format('d, F Y') }} </td>
                                @if ($leave->status == 'Leave out')
                                    <td> {{ date_diff(new \Datetime($leave->due_date), new \DateTime('now'))->format(' %y Years,%m Months,%d days') }}
                                    </td>
                                @else
                                    <td> {{ '-' }} </td>
                                @endif
                                <td> {{ $leave->status }} </td>
                                <td>
                                    <button type="button" data-toggle="modal" data-id="{{ $leave->id }}"
                                        data-target="#check-in" target="_top"
                                        class="btn  btn-sm btn-outline-primary float-right mr-1"> <i
                                            class="la la-user-plus"></i> Check-in </button>
                                    <a href="javascript:void(0)" data-id="{{ $leave->id }}"
                                        class="btn  btn-sm btn-outline-primary float-right mr-1"><i
                                            class="la la-edit"></i> Edit</a>

                                </td>
                            </tr>
                        @endforeach
                        @if (count($leaves) == 0)
                            <tr>
                                <td colspan="7" style="color:red;" class="text-danger text-center">No employee
                                    leaves!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>



                {{-- {!! $leaves->links() !!} --}}
            </div>
        </div>
    </div>
</div>

<!--- ///////////////////////////////////////////////////////////////////-->
<div id="check-in" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5> Employe Check -in</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div>
                    <form id="" method="POST" action="">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Select to check-in status</label>
                                <select class="select2 form-control" required="required" name="status"
                                    style="width:100%;">

                                    <option value=""> ........... </option>
                                    <option value="Returned"> Returned </option>
                                    <option value="Extended"> Extended </option>
                                </select>
                            </div><br>
                            <div class="col-md-12">
                                <label> Description </label>
                                <textarea name="comment" placeholder="Write your comment here..." class="form-control" cols="5"
                                    rows="3"> </textarea>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm btn-info pull-right" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Close
                </button>
                <button class="btn btn-sm btn-success pull-right" onclick="">
                    <i class="ace-icon fa fa-save"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
