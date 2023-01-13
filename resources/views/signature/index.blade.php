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
            <span class="text-capitalize">Signature</span>
            <small>List</small>
        </h2>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header"><i class="fa fa-align-justify"></i> Signature Lists</div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>User</th>
                <th>Action</th>
              </tr>
            </thead>
            @foreach ($idSignatures as $key=>$idSignature)
              <tbody>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $idSignature->user->username }}</td>
                  <td>
                    <a href="{{ route('signature.show', ['signature'=>$idSignature->id]) }}" class="btn btn-default btn-sm" title="edit">
                      <i class="fa fa-eye"></i>
                    </a>
                  </td>
              </tbody>
            @endforeach
          </table>
          <div class="float-right" id="custompaginator">{!! $idSignatures->withQueryString()->links() !!}</div>
        </div>
    </div>
    <div>
        <a href="{{ route('signature.create') }}" class="btn btn-primary">Add Signature</a>
      </div>
    </div>
</div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
@endsection
