@extends(backpack_view('blank'))
@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Placement Rounds' => url(route('placement-round.index')),
        trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    {{-- <section class="container-fluid d-print-none">
        <button type="button" data-toggle="modal" data-target="#promotion" target="_self"
            class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-arrow-up"></i> Promotion</button>
    </section> --}}
@endsection


@section('content')
    <div>
        <h5>Positions</h5>
        <div class=" no-padding no-border">
            <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>Position Name</th>
                        <th>Downloadable File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($positions as $position)
                        <tr>
                            <td>{{ $position?->jobTitle?->name }}</td>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($positions) == 0)
                        <tr>
                            <td colspan="3" class="text-center">No Employee Licence</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div>
                {{ $positions->links() }}
            </div>
        </div>
    </div>
@endsection
