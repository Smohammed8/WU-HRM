@extends('backpack::layouts.plain')
@section('after_scripts')
    <script type="text/javascript">
        function chkcontrol(j) {
            var total = 0;
            for (var i = 0; i < document.choice_form.choice.length; i++) {
                if (document.choice_form.choice[i].checked) {
                    total = total + 1;
                }
                if (total > 2) {
                    alert("Please Select only two position")
                    document.choice_form.choice[j].checked = false;
                    return false;
                }
            }
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
    <div class="row">
        <div class="card col-md-12 mb-2" style="border-radius:1%; border-top-color: blue !important; border-top-width:2px;">
            <div class="card-body">
                <h4> Select 2  position of your choice </h4>
                <div>
                    <form name="choice_form" action="" class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between">
                            <div class="col-md-12 d-flex justify-content-between">

                                <table
                                    class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2 dataTable dtr-inline collapsed has-hidden-columns">
                                    <thead>
                                        <tr>
                                            <td>Unit</td>
                                            <td>Job Title</td>
                                            <td>Total Employees</td>
                                            <td>Minimum Requirement</td>
                                            <td>Select</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($positions as $position_key => $position)
                                            <tr>
                                                <td>{{ $position->unit->name }}</td>
                                                <td>{{ $position->jobTitle->name }}</td>
                                                <td>{{ $position->total_employees }}</td>
                                                <td>
                                                    <label class="form-check-label" for="choice_{{ $position->id }}">
                                                        @foreach ($position->minimumRequirements as $requirment)
                                                            {{ $requirment->experience }} Years in
                                                            {{ $requirment->educationalLevel->name }}
                                                            with minimum efficeny of
                                                            {{ $requirment->minimum_efficeny }}
                                                            and employee profile value
                                                            {{ $requirment->minimum_employee_profile_value }}
                                                        @endforeach
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="choice" onclick="chkcontrol({{$position_key}})" class="form-check-input"
                                                                id="choice_{{ $position->id }}">
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
@endsection
