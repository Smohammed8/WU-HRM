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
            <span class="text-capitalize">ID Design</span>
            <small>List</small>
        </h2>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i> Employee Lists</div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Action</th>
              </tr>
            </thead>
            @foreach ($employees as $key=>$employee)
              <tbody>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $employee->name }}</td>
                  <td>{{ $employee->gender }}</td>
                  <td>
                    <a href="{{ route('print.id', ['employee'=>$employee->id]) }}" class="btn btn-primary btn-sm" title="print">Print
                    </a>
                  </td>
              </tbody>
            @endforeach
          </table>
          <div class="float-right" id="custompaginator">{!! $employees->withQueryString()->links() !!}</div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
@endsection
