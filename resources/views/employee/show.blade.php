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
    	<a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
		<h2>
	        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
	        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
	        @if ($crud->hasAccess('list'))
	          <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
	        @endif
	    </h2>
    </section>
@endsection

@section('content')
{{-- <div class="row">
	<div class="{{ $crud->getShowContentClass() }}">

	  <div class="">
	  	@if ($crud->model->translationEnabled())
			<div class="row">
				<div class="col-md-12 mb-2">

					<div class="btn-group float-right">
					<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						@foreach ($crud->model->getAvailableLocales() as $key => $locale)
							<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?locale={{ $key }}">{{ $locale }}</a>
						@endforeach
					</ul>
					</div>
				</div>
			</div>
	    @endif
	    <div class="card no-padding no-border">
            <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2" cellspacing="0">
                <thead>
                  <tr>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($licenses as $license)
                        <tr>
                            <td>{{ $license->licenseType->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <tr>
                  </tr>
                </tfoot>
              </table>
	    </div>
	  </div>

	</div>
</div> --}}
<div class="row">
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2" style="border-right:1px solid black;">
                    <img width="150" src="{{ $crud->entry->photo }}" alt="">
                </div>
                <div class="col-md-9">
                    <div class="row justify-content-between">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Employee Name : </b>  </label>
                                <label for="">{{ $crud->entry->name }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Employee Gender : </b></label>
                                <label for="">{{ $crud->entry->gender }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Phone Number : </b></label>
                                <label for="">{{ $crud->entry->phone_number }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Ethnicity : </b></label>
                                <label for="">{{ $crud->entry->ethnicity->name }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Religion : </b></label>
                                <label for="">{{ $crud->entry->religion->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-6" style="border-left:1px solid black;">
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Blood group : </b>  </label>
                                <label for="">{{ $crud->entry->blood_group }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Alternate email : </b></label>
                                <label for="">{{ $crud->entry->alternate_email }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Age : </b></label>
                                <label for="">{{ 20 }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Marital status : </b></label>
                                <label for="">{{ $crud->entry->maritalStatus->name }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for=""><b>Employee ID Number : </b></label>
                                <label for="">{{ $crud->entry->employment_identity }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="tab-container mb-2 row">
    <div class="nav-tabs-custom p-0 d-flex  col-md-12" id="form_tabs">
        <div class="col-md-2  p-0 m-0" style="border-right:1px solid black;">
            <ul class="nav nav-tabs nav-stacked flex-column " role="tablist">
                <li role="presentation" class="nav-item">
                    <a href="#tab_employee_job" aria-controls="tab_employee_job" role="tab" tab_name="employee_job" data-toggle="tab" class="nav-link active" >{{ 'Employee Job' }}</a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#tab_employee_address" aria-controls="tab_employee_address" role="tab" tab_name="employee_address" data-toggle="tab" class="nav-link " >{{ 'Employee Address' }}</a>
                </li>
            </ul>
        </div>
        <div class="tab-content box m-0 col-md-10 p-0 v-pills-tabContent">
            <div role="tabpanel" class="tab-pane active" id="tab_employee_address">
                <h3>Employee Address</h3>
                <div class=" no-padding no-border">
                    <div class="">
                        <a href="{{ route('{employee}/employee-address.create',['employee'=>$crud->entry->id]) }}" class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> {{ trans('backpack::crud.add') }} {{ 'Employee Address'}}</span></a>
                    </div>
                    <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Address Type</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($employeeAddresses as $employeeAddress)
                                <tr>
                                    <td>{{ $employeeAddress->name }}</td>
                                    <td>{{ $employeeAddress->address_type }}</td>
                                    <td>
                                        <a href="{{ route('{employee}/employee-address.edit', ['employee'=>$crud->entry->id,'id'=>$employeeAddress->id]) }}" class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                        <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ route('{employee}/employee-address.destroy', ['employee'=>$crud->entry->id,'id'=>$employeeAddress->id]) }}" class="btn btn-sm btn-link" data-button-type="delete"><i class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            @empty($employeeAddresses->items)
                                <tr>
                                    <td colspan="3" class="text-center">No Employee Address</td>
                                </tr>
                            @endempty
                        </tbody>
                      </table>
                      <div>
                        {{ $employeeAddresses->links() }}
                      </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab_employee_job">
                <h3>Employee Job</h3>
            </div>
        </div>
    </div>
</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css').'?v='.config('backpack.base.cachebusting_string') }}">
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/show.css').'?v='.config('backpack.base.cachebusting_string') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('packages/backpack/crud/js/crud.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
	<script src="{{ asset('packages/backpack/crud/js/show.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
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
                              if (typeof crud != 'undefined' && typeof crud.table != 'undefined') {
                                  // Move to previous page in case of deleting the only item in table
                                  if(crud.table.rows().count() === 1) {
                                    crud.table.page("previous");
                                  }
                                  $(button).parent().parent().remove();
                                  crud.table.draw(false);
                              }

                                // Show a success notification bubble
                              new Noty({
                                type: "success",
                                text: "{!! '<strong>'.trans('backpack::crud.delete_confirmation_title').'</strong><br>'.trans('backpack::crud.delete_confirmation_message') !!}"
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
                                } else {// Show an error alert
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
