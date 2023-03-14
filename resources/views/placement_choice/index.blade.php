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
            <span class="text-capitalize">Placement Choice</span>
            <small>List</small>
        </h2>
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> 
            All placement choices
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Placement Round</th>
                <th>Employee Full name</th>
                <th>Employee first choice</th>
                <th>Employee second choice</th>
                <th>Action</th>
              </tr>
            </thead>
            @foreach ($placementChoices as $key=>$placementChoice)
                <tbody>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $placementChoice->placementRound?->round }}</td>
                    <td>{{ $placementChoice->employee?->getNameAttribute() }}</td>
                    <td>{{ $placementChoice->choiceOne?->name }}</td>
                    <td>{{ $placementChoice->choiceTwo?->name }}</td>
                    <td>
                    {{-- <a href="{{ route('idcard.show', ['idcard'=>$idcard->id]) }}" class="btn btn-default btn-sm" title="edit">
                        <i class="fa fa-eye"></i>
                    </a>

                    <a href="{{ route('idcard.design', ['idcard'=>$idcard->id]) }}" class="btn btn-danger btn-sm" title="edit">Design
                    </a> --}}
                    </td>
                </tbody>
            @endforeach
          </table>
          <div class="navigation">
            {{ $placementChoices->links() }}
          </div>
        </div>
    </div>
    <div>
      <a href="{{ route('placement-choice.create', ['placement_round'=>$placementRound->id]) }}" class="btn btn-primary">Choose Placement</a>
    </div>
    </div>
</div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
@endsection
