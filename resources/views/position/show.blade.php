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

@section('header')
    <section class="container-fluid d-print-none">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')) . ' ' . $crud->entity_name !!}.</small>
            @if ($crud->hasAccess('list'))
                <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i>
                        {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="card col-md-12 mb-2" style="border-radius:1%; border-top-color: blue !important; border-top-width:2px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Position Detail</h3>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Organization : </b> </label>
                                    <label for="">{{ $crud->entry->unit->organization->name }}</label>
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
                                    <label for=""><b>Position Available for placement : </b></label>
                                    <label for="">{{ $crud->entry->available_for_placement }}</label>
                                </div>
                            </div>
                            <div class="col-md-6" style="border-left:1px solid black;">
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Total Employees : </b></label>
                                    <label for="">{{ $crud->entry->total_employees }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Position Type: </b></label>
                                    <label for="">{{ $crud->entry->jobTitle->positionType?->title }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Is it available for placement : </b></label>
                                    <label for="">{{ $crud->entry->available_for_placement ? 'Yes' : 'No' }}</label>
                                </div>
                                {{-- <div class="d-flex justify-content-between">
                                    <label for=""><b>Status : </b></label>
                                    <label
                                        for="">{{ \App\Constants::POSITION_STATUS[$crud?->entry?->status] }}</label>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        {{-- <div class="card col-md-12 mb-2" style="border-radius:1%; border-top-color: blue !important; border-top-width:2px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <h3>Minimum Requirements</h3>
                        <a href="{{ route('{position}/minimum-requirement.create', ['position' => $crud->entry->id]) }}"
                            class="btn btn-primary btn-sm" data-style="zoom-in"><span class="ladda-label"><i
                                    class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                {{ 'Minimum Requirement' }}</span></a>
                    </div>
                    <div class="col-md-12">
                        <div class="no-padding no-border">

                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Experience</th>
                                        <th>Education</th>
                                        <th>Min Efficency</th>
                                        <th>Min Profile Value</th>
                                        <th>Related Jobs</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($minimumRequirements as $minimumRequirement)
                                        <tr>
                                            <td>{{ $minimumRequirement->experience }} Years</td>
                                            <td>{{ $minimumRequirement->educationalLevel->name }}</td>
                                            <td>{{ $minimumRequirement->minimum_efficeny }}</td>
                                            <td>{{ $minimumRequirement->minimum_employee_profile_value }}</td>
                                            <td>
                                                @foreach ($minimumRequirement->relatedJobs as $relatedJob)
                                                    {{ $relatedJob->jobTitle->name . ', ' }}
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('{position}/minimum-requirement.edit', ['position' => $crud->entry->id, 'id' => $minimumRequirement->id]) }}"
                                                    class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                    data-route="{{ route('{position}/minimum-requirement.destroy', ['position' => $crud->entry->id, 'id' => $minimumRequirement->id]) }}"
                                                    class="btn btn-sm btn-link" data-button-type="delete"><i
                                                        class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($minimumRequirements) == 0)
                                        <tr>
                                            <td colspan="6" class="text-center">No Minimum Requirement for this job</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    {{-- </div> --}}
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
