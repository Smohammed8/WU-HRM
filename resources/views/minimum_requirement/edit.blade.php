@extends(backpack_view('blank'))

@php
$defaultBreadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.edit') => false,
];

// if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.edit') . ' ' . $crud->entity_name !!}.</small>

            {{-- @if ($crud->hasAccess('list'))
                <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i
                            class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif --}}
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getEditContentClass() }}">
            <!-- Default box -->

            @include('crud::inc.grouped_errors')

            <form method="post" action="{{ url($crud->route . '/' . $entry->getKey()) }}"
                @if ($crud->hasUploadFields('update', $entry->getKey())) enctype="multipart/form-data" @endif>
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}

                @if ($crud->model->translationEnabled())
                    <div class="mb-2 text-right">
                        <!-- Single button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ trans('backpack::crud.language') }}:
                                {{ $crud->model->getAvailableLocales()[request()->input('locale') ? request()->input('locale') : App::getLocale()] }}
                                &nbsp; <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                                    <a class="dropdown-item"
                                        href="{{ url($crud->route . '/' . $entry->getKey() . '/edit') }}?locale={{ $key }}">{{ $locale }}</a>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                @endif
                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                @include('crud::form_content', ['fields' => $crud->fields(), 'action' => 'edit'])
                <div class="">

                </div>
                @include('crud::inc.form_save_buttons')
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Related Job</th>
                    <th>Action</th>
                </tr>
                @foreach ($crud->entry->relatedJobs as $relatedJob)
                    <tr>
                        <td>{{ $relatedJob->jobName }}</td>
                        {{-- {{ route('{position}/{minimum_requirement}/related-work.destroy',['position'=>$crud->entry->postion_id,'minimum_requirement'=>$crud->entry->id,'id'=>$relatedJob->id]) }} --}}
                        <form action="" action="POST">
                            @csrf
                            <td>
                                <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                    data-route="{{ route('{position}/{minimum_requirement}/related-work.destroy', ['position' => $crud->entry->position_id, 'minimum_requirement' => $crud->entry->id, 'id' => $relatedJob->id]) }}"
                                    class="btn btn-sm btn-link" data-button-type="delete"><i class="la la-trash"></i>
                                    {{ trans('backpack::crud.delete') }}</a>
                            </td>
                        </form>
                    </tr>
                @endforeach
                @if (($crud->entry->relatedJobs()->count()==0))
                    <tr>
                        <td class="text-center" colspan="2">No Related Job</td>
                    </tr>
                @endif
            </table>

        </div>
    </div>

    <script>
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

        // make it so that the function above is run after each DataTable draw event
        // crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
    </script>
@endsection
