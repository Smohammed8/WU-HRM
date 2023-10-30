@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.min.css') }}" rel="stylesheet" type="text/css" />

@section('header')
    <section class="container-fluid d-print-none">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')) . ' ' . $crud->entity_name !!}.</small>
            @if ($crud->hasAccess('list'))
                <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i
                            class="la la-angle-double-left"></i>
                        {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="card col-md-12 mb-2" style="border-radius:1%; border-top-color: #0067b8 !important; border-top-width:2px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Position Detail</h3>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Total Permitted Positions: </b> </label>
                                    <label for="">  <span class="badge badge-pill badge-danger border">{{  $crud->entry->positions->count() }} </span></label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Unit Name : </b> </label>
                                    <label for="">{{ $crud->entry->unit->name }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Job Title : </b></label>
                                    <label for="">{{ $crud->entry->jobTitle->name }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Open positions : </b></label>
                                    <label for="">{{ $crud->entry->available_for_placement }}</label>
                                </div>
                            </div>
                            <?php $count = 0; ?>
                            @foreach ($positionCodes as $positionCode)
                             @if($positionCode->employee == null)
                             <?php  $count ++ ?>
                             @endif
                            @endforeach
                            <div class="col-md-6" style="border-left:1px solid black;">
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Free Positions : </b></label>
                                    <label for=""> <span class="badge badge-pill badge-info border">{{  $count }} </span></label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Position Type: </b></label>
                                    <label for="">{{ $crud->entry->jobTitle->positionType?->title }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Locked Positions : </b></label>
                                    <label
                                        for="">{{ $crud->entry->available_for_placement ? '0' : '0' }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <label for="">Add New Position</label>
            <button class="btn float-right" data-toggle="collapse" data-target="#newJobCodeCollapse"><i
                    class="la la-angle-down"></i></button>
        </div>
        <div class="card-body">
            <div class="row @if($errors->has('job_code_starting_number')==null) collapse @endif" id="newJobCodeCollapse">
                <form method="POST" action="{{ route('position/{position}/position-code.store', ['position'=>$crud->getCurrentEntry()->id]) }}" class="row col-md-12">
                    @csrf
                    <input type="hidden" name="position_id" value="{{ $crud->getCurrentEntry()->id }}">

                    <div class="form-group col-md-4">
                        <label for=""> Prefix </label>
                
                        <select name="job_code_prefix" class="form-control" required>
                            <option value=""> --------Select prefix----------- </option>
                            @foreach ($prefixes as $college)
                                <option value="{{ $college->prefix }}">{{ $college->prefix  }}</option>
                            @endforeach
                        </select>

                        @error('job_code_prefix')
                        <span class="{{ 'text-danger' }}">{{ $message }}</span>
                    @enderror
                     
                    </div>

                    <div class="form-group col-md-4">
                        <label for=""> Start Job Code</label>
                        <input type="number" min="1" name="job_code_starting_number" class="form-control" id="" required>
                       
                        @error('job_code_starting_number')
                        <span class="{{ 'text-danger' }}">{{ $message }}</span>
                    @enderror
                     
                    </div>
             
                    <div class="form-group col-md-4">
                        <label for="">Total Positions</label>
                        <input type="number" min="1"  max="700" name="total_codes" class="form-control" id="" required>
                        @error('total_codes')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> 

                    <div class="col-md-12">
                        <input type="submit" value="Create New Position" class="float-right btn btn-sm btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card col-md-12 mb-2" style="border-radius:0%; border-top-color: #0067b8 !important; border-top-width:2px;">
        <div class="card-body">
            <div class="row">
                {{-- <label for=""></label> --}}

                <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>አሁን የስራ መደቡን የያዘዉ ሰራትኛ</th>
                            <th>የስራ መደቡ መለያ</th>
                          
                            <th>የስራ መደብ </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($positionCodes as $positionCode)
                            <tr>
                          
                              
                                    <td> {{ $loop->index + 1 }} </td>
                                <td>
                                    <a
                                        href="{{ $positionCode?->employee != null ? route('employee.show', ['id' => $positionCode?->employee?->id]) : '#' }}">{{ $positionCode?->employee?->name ?? '-' }}</a>
                                </td>
                                <td>{{ $positionCode->code }}</td>
                            <td>
                                @if($positionCode->employee_id != null)
                                {{  $positionCode->position->jobTitle->name }}
                                @else
                                {{  '-' }}
                                @endif
                              </td>
                              
                                <td>
                                    <a href="#"
                                        onclick="editEntry('{{ route('position/{position}/position-code.update', ['position' => $crud->entry->id, 'id' => $positionCode->id]) }}','{{ $positionCode->code }}')"
                                        data-toggle="modal" data-target="#position_code_edit" target="_self">
                                        <i class="la la-edit"></i> Edit
                                    </a>
                                    @if ($positionCode->employee == null)
                                        <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                            data-route="{{ route('position/{position}/position-code.destroy', ['position' => $crud->entry?->id, 'id' => $positionCode->id]) }}">
                                            <i class="la la-trash"></i> Delete
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="m-auto float-right" id="pagi">
                {{ $positionCodes->links() }}
            </div>
        </div>
    </div>


    <div class="modal fade" data-backdrop="false" id="position_code_edit" tabindex="-1" role="dialog"
        aria-labelledby="position_code_edit" aria-hidden="true">
        <div class="modal-dialog modal-full" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editPositionModalLabel">Edit Position Code</h6>

                    <button type="button" class="btn  btn-sm btn-outline-primary pull-right mr-1" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true"> <i class="la la-times"></i> Close </span>
                    </button>
                </div>
                <div class="" id="position_code_edit_collapse">
                    <div class="card card-body">
                        <!--- ////////////////////// leave form ----------->
                        <form action="" id="position_code_edit_form" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Current Job Code</label>
                                <input type="text" value="@error('old_job_code') {{ $message }} @enderror"
                                    disabled name="old_job_code" id="old_job_code" class="form-control disabled">
                            </div>
                            <div class="form-group">
                                <label for="">New Job Code</label>
                                <input type="text" value="{{ old('code') }}" name="code" id="job_code"
                                    class="form-control">
                                @error('code')
                                    <span class="{{ 'text-danger' }}">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="submit" value="Change Code" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('after_styles')
    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/crud.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/show.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
@endsection
@section('after_scripts')
    <script src="{{ asset('packages/backpack/crud/js/crud.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>
    <script src="{{ asset('packages/backpack/crud/js/show.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>
    <script>
        $(function() {
            @if (old('code') != null && $errors->has('new')==false)
                $('#position_code_edit').modal('show')
            @endif
        });

        function editEntry(route, value) {
            $('#position_code_edit_form').attr('action', route);
            $('#old_job_code').val(value);
            $('#job_code').val('');
        }
        if (typeof deleteEntry != 'function') {
            $("[data-button-type=delete]").unbind('click');

            function deleteEntry(button) {
                // ask for confirmation before deleting an item
                // e.preventDefault();
                var route = $(button).attr('data-route');

                swal({
                    title: "{!! trans('backpack::base.warning') !!}",
                    text: "{!! trans('backpack::crud.delete_confirm') !!}",
                    icon: "warning",
                    buttons: ["{!! trans('backpack::crud.cancel') !!}", "{!! trans('backpack::crud.delete') !!}"],
                    dangerMode: true,
                }).then((value) => {
                    if (value) {
                        $.ajax({
                            url: route,
                            type: 'DELETE',
                            success: function(result) {
                                $(button).parent().parent().remove();
                                if (result == 1) {
                                    // Redraw the table
                                    if (typeof crud != 'undefined' && typeof crud.table !=
                                        'undefined') {
                                        // Move to previous page in case of deleting the only item in table
                                        if (crud.table.rows().count() === 1) {
                                            crud.table.page("previous");
                                        }
                                        $(button).parent().parent().remove();
                                        crud.table.draw(false);
                                    }

                                    // Show a success notification bubble
                                    new Noty({
                                        type: "success",
                                        text: "{!! '<strong>' .
                                            trans('backpack::crud.delete_confirmation_title') .
                                            '</strong><br>' .
                                            trans('backpack::crud.delete_confirmation_message') !!}"
                                    }).show();

                                    // Hide the modal, if any
                                    $('.modal').modal('hide');
                                } else {
                                    // if the result is an array, it means
                                    // we have notification bubbles to show
                                    if (result instanceof Object) {
                                        // trigger one or more bubble notifications
                                        Object.entries(result).forEach(function(entry, index) {
                                            var type = entry[0];
                                            entry[1].forEach(function(message, i) {
                                                new Noty({
                                                    type: type,
                                                    text: message
                                                }).show();
                                            });
                                        });
                                    } else { // Show an error alert
                                        swal({
                                            title: "{!! trans('backpack::crud.delete_confirmation_not_title') !!}",
                                            text: "{!! trans('backpack::crud.delete_confirmation_not_message') !!}",
                                            icon: "error",
                                            timer: 4000,
                                            buttons: false,
                                        });
                                    }
                                }
                            },
                            error: function(result) {
                                // Show an alert with the result
                                swal({
                                    title: "{!! trans('backpack::crud.delete_confirmation_not_title') !!}",
                                    text: "{!! trans('backpack::crud.delete_confirmation_not_message') !!}",
                                    icon: "error",
                                    timer: 4000,
                                    buttons: false,
                                });
                            }
                        });
                    }
                });

            }
        }

        // make it so that the function above is run after each DataTable draw event
        // crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
    </script>
@endsection
