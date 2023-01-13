{{-- @extends('base') --}}
@extends(backpack_view('blank'))


<link rel="stylesheet" type="text/css" href="{{ asset('tree.css') }}" />


@section('content')
    <div class="btn-primary"></div>
    <div class="body genealogy-body genealogy-scroll justify-content-center">
        <div class="genealogy-tree">
        </div>
        <div class="genealogy-tree">
            <x-tree-root :children="$orgs"></x-tree-root>
        </div>
    </div>
@endsection
@section('after_scripts')
    <script src="{{ asset('tree.js') }}" type="text/javascript"></script>
@endsection
