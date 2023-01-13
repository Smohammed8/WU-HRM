@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [

    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <h2>
            <span class="text-capitalize">New ID Attribute</span>
        </h2>
    </section>
@endsection

@section('content')
<form action="{{ route('attribute.store') }}" method="post" >
  @csrf
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header"><strong>New Attribute</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" id="name" name="name" type="text" placeholder="Enter Attribute Name">
              </div>
            </div>
          </div>
          
      </div>
    </div>
    <button class="btn btn-success">Submit</button>
    </div>
  </div>
</form>
@endsection


@section('after_styles')
@endsection

@section('after_scripts')
@endsection
