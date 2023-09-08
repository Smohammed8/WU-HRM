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
        <div class="col-lg-12">
            <form action="{{ route('placement-choice.store', ['placement_round'=>$placementRound->id]) }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        Add placement choices
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Select Employee</label>
                                <select name="employee" class="form-control select2" id="employee">
                                    <option value="">Select an employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->getNameAttribute() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Choose first choice</label>
                                <select name="first_choice" class="form-control select2" id="choice_one">
                                    <option value="">Select first choice</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="second">
                                <label>Choose Second choice</label>
                                <select name="second_choice" class="form-control select2" id="choice_two">
                                    <option value="">Select second choice</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('after_styles')
@endsection
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var val_one, val_two;
        function check(pos, val) {
            return pos == val ? 'selected' : '';
        }
        $(function() {
            var positions = {!! json_encode($positions) !!};
            console.log(positions.length);
            $('.select2').select2();
            positions.forEach(position => {
                $("#choice_one").append(
                    '<option value="'+position.id+'">'+position.position_info_for_placement+'</option>'
                );
                $("#choice_two").append(
                    '<option value="'+position.id+'">'+position.position_info_for_placement+'</option>'
                );
            });
            
        });    

        $("#employee").change(function() {
            $.ajax({
                type: "POST",
                url: "/choice-based-employee",
                // method: 'post',
                data: {
                    'employee_id': this.value,
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(result){
                    console.log(result.positions.length);
                    $("#choice_one").html("");
                    $("#choice_two").html("");
                    $("#choice_one").append(
                        '<option value="">Select first choice</option>'
                    );
                    $("#choice_two").append(
                        '<option value="">Select second choice</option>'
                    );
                    result.positions.forEach(position => {
                        $("#choice_one").append(
                            '<option value="'+position.id+'" '+check(position.id, val_one)+'>'+position.position_info_for_placement+'</option>'
                        );
                        $("#choice_two").append(
                            '<option value="'+position.id+'" '+check(position.id, val_two)+'>'+position.position_info_for_placement+'</option>'
                        );
                    });
                },
            });
        });

        $("#choice_one").change(function() {
            val_one = $("#choice_one").val()
            $.ajax({
                type: "POST",
                url: "/remove-choosed-position",
                // method: 'post',
                data: {
                    'position_id': this.value,
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(result){
                    console.log(result.positions.length);
                    $("#choice_two").html("");
                    $("#choice_two").append(
                        '<option value="">Select second choice</option>'
                    );
                    result.positions.forEach(position => {
                        $("#choice_two").append(
                            '<option value="'+position.id+'" '+check(position.id, val_two)+'>'+position.position_info_for_placement+'</option>'
                        );
                    });
                },
            });
        });

        $("#choice_two").change(function() {   
            val_two = $("#choice_two").val();
            $.ajax({
                type: "POST",
                url: "/remove-choosed-position",
                // method: 'post',
                data: {
                    'position_id': this.value,
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(result){
                    console.log(result.positions.length);
                    $("#choice_one").html("");
                    $("#choice_one").append(
                        '<option value="">Select first choice</option>'
                    );
                    
                    result.positions.forEach(position => {
                        console.log(this.id);
                        $("#choice_one").append(
                            '<option value="'+position.id+'" '+check(position.id, val_one)+'>'+position.position_info_for_placement+'</option>'
                        );
                    });
                },
            });
        });
    </script>
@endsection
