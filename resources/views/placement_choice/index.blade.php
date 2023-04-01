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
        <div class="col-sm-3">
            <div class="d-print-none with-border display-inline float-end mb-3">
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
        <div class="col-sm-6">
            <form action="{{ route('placement_choice.list_all', ['placement_round'=>$placementRound->id]) }}" method="get">
                <div class="row">
                    <div class="col-sm-5">
                        <select class="form-control form-control-md select2" name="unit">
                        <option value="0">Select Unit</option>
                        @foreach ($allUnits as $allUnit)
                            <option value="{{ $allUnit->id }}" {{ $allUnit->id == app('request')->get('unit') ? 'selected' : '' }}>{{ $allUnit->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="">
                            <div class="col-form-label">
                              <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-checkbox1" type="checkbox" value="yes" name="all_checked" {{ app('request')->get('all_checked') == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inline-checkbox1">Only its positions</label>
                              </div>
                              {{-- <div class="form-check form-check-inline mr-1">
                                <input class="form-check-input" id="inline-radio2" type="radio" value="yes" name="all_checked" {{ old('all_checked') == 'no' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inline-radio2">All unit positions</label>
                              </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button style="width: 100%" class="btn btn-primary btn-md" name="filter" value="filter">Filter</button>
                    </div>
                    <div class="col-sm-2">
                        <a style="width: 100%" href="{{ route('placement_choice.list_all', ['placement_round' => $placementRound->id]) }}"
                            class="btn btn-outline-primary" data-style="zoom-in">
                            <span class="ladda-label">
                                Reset
                            </span>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-sm-3">
            <div class="d-print-none with-border display-inline float-end mb-3">
                 @if ($placementRound->status >= \App\Constants::PLACEMENT_ROUND_STATUS_OPENED)
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export Choice</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a href="#"
                            class="dropdown-item" data-style="zoom-in">
                            <span class="ladda-label">
                                EXCEL
                            </span>
                        </a>
                        <a href="#"
                            class="dropdown-item" data-style="zoom-in">
                            <span class="ladda-label">
                                PDF
                            </span>
                        </a>
                        </div>
                    </div>
                 @endif
     
                 @if ($placementRound->status == \App\Constants::PLACEMENT_ROUND_STATUS_APPROVED)
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" id="dropdownMenu2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export Result</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a href="#"
                            class="dropdown-item" data-style="zoom-in">
                            <span class="ladda-label">
                                EXCEL
                            </span>
                        </a>
                        <a href="#"
                            class="dropdown-item" data-style="zoom-in">
                            <span class="ladda-label">
                                PDF
                            </span>
                        </a>
                        </div>
                    </div>
                 @endif
            </div>
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
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            @foreach ($unit->getPositionedChoice() as $key => $placementChoice)
                                <tbody>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $placementChoice->employee?->getNameAttribute() }}</td>
                                    <td>{{ $placementChoice->choiceOne?->name }}</td>
                                    <td>{{ $placementChoice->choiceTwo?->name }}</td>
                                    {{-- <td>
                                    </td> --}}
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2();
    </script>
@endsection
