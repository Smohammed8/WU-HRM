@extends('backpack::layouts.plain')
@push('after_styles')
    <style>
        footer {
            display: none !important;
        }
    </style>
@endpush
@section('after_scripts')
    <script type="text/javascript">
        $(function() {
            const checkboxes = document.getElementsByName("choice_one_id");
            // Loop through all checkboxes
            for (let i = 0; i < checkboxes.length; i++) {
                // Add a click event listener to each checkbox
                checkboxes[i].addEventListener("click", function() {
                    // If the current checkbox is checked, uncheck all other checkboxes
                    if (this.checked) {
                        for (let j = 0; j < checkboxes.length; j++) {
                            if (i !== j) {
                                checkboxes[j].checked = false;
                            }
                        }
                    }
                });
            }
            const checkboxes1 = document.getElementsByName("choice_two_id");
            // Loop through all checkboxes
            for (let i = 0; i < checkboxes1.length; i++) {
                checkboxes1[i].addEventListener("click", function() {
                    if (this.checked) {
                        for (let j = 0; j < checkboxes1.length; j++) {
                            if (i !== j) {
                                checkboxes1[j].checked = false;
                            }
                        }
                    }
                });
            }
        })

        function chkcontrol(j) {
            // var total = 0;
            // for (var i = 0; i < document.choice_form.choice.length; i++) {
            //     if (document.choice_form.choice[i].checked) {
            //         total = total + 1;
            //     }
            //     if (total > 2) {
            //         alert("Please Select only two position")
            //         document.choice_form.choice[j].checked = false;
            //         return false;
            //     }
            // }
        }
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="card col-md-12 mb-2" style="border-radius:1%; border-top-color: blue !important; border-top-width:2px;">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4> Welcome {{ $user?->name }} </h4>
                    {{-- <form action="/logout" method="POST"> --}}
                    @csrf
                    <a href="/logout" class="">Logout</a>
                    {{-- </form> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2" style="border-right:1px solid black;">
                        <img src="{{ $employee->photo }}" alt="profile Pic" height="160" width="150">
                    </div>
                    <div class="col-md-9">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Employee Name : </b> </label>
                                    <label for="">{{ $employee->name }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Employee Gender : </b></label>
                                    <label for="">{{ $employee->gender }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Phone Number : </b></label>
                                    <label for="">{{ $employee->phone_number }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Ethnicity : </b></label>
                                    <label for="">{{ $employee->ethnicity?->name }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Religion : </b></label>
                                    <label for="">{{ $employee->religion?->name }}</label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Last Efficinecy : </b></label>
                                    <label for="">{{ '-' }}</label>
                                </div>
                            </div>

                            <div class="col-md-6" style="border-left:1px solid black;">
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Blood group : </b> </label>
                                    <label for="">{{ $employee->blood_group }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Alternate email : </b></label>
                                    <label for="">{{ $employee->alternate_email }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Age : </b></label>
                                    <label for="">{{ 20 }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Marital status : </b></label>
                                    <label for="">{{ $employee->maritalStatus?->name }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Employee ID Number : </b></label>
                                    <label for="">{{ $employee->employment_identity }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Gross Salary : </b></label>
                                    <label for=""> ETB {{ number_format($employee->static_salary, 2) }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($placementRound != null)
        <div class="row">
            <div class="card col-md-12 mb-2"
                style="border-radius:1%; border-top-color: blue !important; border-top-width:2px;">
                <div class="card-body">
                    <h4> Select 2 position of your choice </h4>
                    <div>
                        <form name="choice_form" action="{{ route('employee.placement_choice.store', ['placement_round'=>$placementRound->id]) }}" method="POST"
                            class="row">
                            @csrf
                            <input type="hidden" name="placement_round_id" value="{{ $placementRound->id }}">
                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                            <div class="col-md-12">
                                <div class="row justify-content-between">
                                    <div class="col-md-12 d-flex justify-content-between">
                                        <table
                                            class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2 dataTable dtr-inline collapsed has-hidden-columns">
                                            <thead>
                                                <tr>
                                                    <td>Unit</td>
                                                    <td>Job Title</td>
                                                    <td>Positions</td>
                                                    <td>Minimum Requirement</td>
                                                    <td>Choice One</td>
                                                    <td>Choice Two</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($positions as $position_key => $position)
                                                    <tr>
                                                        <td>{{ $position->unit->name }}</td>
                                                        <td>{{ $position->jobTitle->name }}</td>
                                                        <td>{{ $position->total_employees }}</td>
                                                        <td>
                                                            <label class="form-check-label" for="">
                                                                {{ $position->jobTitle->work_experience }} Years
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="choice_one_id"
                                                                        onclick="chkcontrol({{ $position_key }})"
                                                                        {{ $placementChoice?->choice_one_id == $position->id ?'checked':'' }}
                                                                        class="form-check-input"
                                                                        id="choice_{{ $position->id }}"
                                                                        value="{{ $position->id }}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="choice_two_id" {{ $placementChoice?->choice_two_id == $position->id ?'checked':'' }}
                                                                        onclick="chkcontrol({{ $position_key }})"
                                                                        class="form-check-input"
                                                                        id="choice_{{ $position->id }}"
                                                                        value="{{ $position->id }}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary ml-2">Add Position</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
