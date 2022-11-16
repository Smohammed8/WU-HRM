@extends('backpack::layouts.plain')
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
                                    <label for="">{{ $employee->ethnicity->name }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Religion : </b></label>
                                    <label for="">{{ $employee->religion->name }}</label>
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
                                    <label for="">{{ $employee->maritalStatus->name }}</label>
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
                <h4> Choose Your Position Choice </h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="col-md-5">
                                    <select name="" id="" class="form-control select2">
                                        <option value="">Abdi</option>
                                        <option value="">Jack</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <select name="" id="" class="form-control select2">
                                        <option value="">Abdi</option>
                                        <option value="">Jack</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary ml-2">Add Position</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
