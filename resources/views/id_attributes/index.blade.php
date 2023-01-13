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
            <span class="text-capitalize">ID Attributes</span>
            <small>List</small>
        </h2>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i> All ID Attributes</div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Action</th>
              </tr>
            </thead>
            @foreach ($attributes as $key=>$attribute)
              <tbody>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $attribute->name }}</td>
                  <td>
                    <a href="{{ route('attribute.show', ['attribute'=>$attribute->id]) }}" class="btn btn-default btn-sm" title="edit">
                      <i class="fa fa-eye"></i>
                    </a>

                    <a href="{{ route('attribute.edit', ['attribute'=>$attribute->id]) }}" class="btn btn-warning btn-sm" title="edit"><i class="fa fa-pen"></i>
                    </a>
                  </td>
              </tbody>
            @endforeach
          </table>
          <div class="float-right" id="custompaginator">{!! $attributes->withQueryString()->links() !!}</div>
        </div>
    </div>
    <div>
      <a href="{{ route('attribute.create') }}" class="btn btn-primary">New</a>
    </div>
    </div>
</div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
@endsection
