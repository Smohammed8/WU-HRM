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
        <div class="card-header"><i class="fa fa-align-justify"></i> All ID Designs</div>
        <div class="card-body">
            <table class="table">
                {{-- @dd(URL::to('/').'/storage/idcard/'.$iDCard->front_page) --}}
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $iDCard->name }}</td>
                    </tr>
                    <tr>
                        <th>FrontTemplate</th>
                        <td><img width="200" height="100" src="{{ URL::to('/').'/storage/idcard/'.$iDCard->front_page }}"></td>
                    </tr>
                    <tr>
                        <th>BackTemplate</th>
                        <td><img width="200" height="100" src="{{ URL::to('/').'/storage/idcard/'.$iDCard->back_page }}"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
      <a href="{{ route('idcard.create') }}" class="btn btn-primary">New</a>
    </div>
    </div>
</div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
@endsection