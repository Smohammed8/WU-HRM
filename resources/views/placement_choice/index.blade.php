@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [];

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
        <div class="d-print-none with-border display-inline float-right">
            @if (
                $placementRound->status > \App\Constants::PLACEMENT_ROUND_STATUS_OPENED &&
                    $placementRound->status < \App\Constants::PLACEMENT_ROUND_STATUS_APPROVED)
                <a href="{{ route('placement.reset', ['placement_round' => $placementRound->id]) }}"
                    class="btn btn-outline-primary" data-style="zoom-in">
                    <span class="ladda-label">
                        Reset Action
                    </span>
                </a>
            @endif
            @if ($placementRound->status == \App\Constants::PLACEMENT_ROUND_STATUS_OPENED)
                <a href="{{ route('compute_rank', ['placement_round' => $placementRound->id]) }}"
                    class="btn btn-outline-primary" data-style="zoom-in">
                    <span class="ladda-label">
                        Compute Rank
                    </span>
                </a>
            @endif
            @if ($placementRound->status == \App\Constants::PLACEMENT_ROUND_STATUS_RANKED)
                <a href="{{ route('place', ['placement_round' => $placementRound->id]) }}" class="btn btn-outline-primary"
                    data-style="zoom-in">
                    <span class="ladda-label">
                        Make Placement
                    </span>
                </a>
            @endif

            @if ($placementRound->status == \App\Constants::PLACEMENT_ROUND_STATUS_PLACED)
                <a href="{{ route('placement.approve', ['placement_round' => $placementRound->id]) }}"
                    class="btn btn-outline-primary" data-style="zoom-in">
                    <span class="ladda-label">
                        Approve Placement
                    </span>
                </a>
            @endif

            @if ($placementRound->status == \App\Constants::PLACEMENT_ROUND_STATUS_APPROVED)
                <a href="{{ route('placement.close', ['placement_round' => $placementRound->id]) }}"
                    class="btn btn-outline-primary" data-style="zoom-in">
                    <span class="ladda-label">
                        Close Placement
                    </span>
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        @foreach ($units as $unit)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        {{ $unit->name }}
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Placement Round</th> --}}
                                    <th>Employee Full name</th>
                                    <th>Employee first choice</th>
                                    <th>Employee second choice</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($unit->getPositionedChoice() as $key => $placementChoice)
                                <tbody>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $placementChoice->employee?->getNameAttribute() }}</td>
                                    <td>{{ $placementChoice->choiceOne?->name }}</td>
                                    <td>{{ $placementChoice->choiceTwo?->name }}</td>
                                    <td>
                                    </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="navigations">
        {{ $units->links() }}
    </div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
@endsection
