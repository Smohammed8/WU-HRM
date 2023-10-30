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
<style>
    .container {
  height: 100vh;
  max-width: 100% !important;
}
.card {
  border: 1px solid #ccc;
}

.card-header {
  border-bottom: 1px solid #ccc;
}

.card-body {
  border-top: 1px solid #ccc;
}

.card-header h5 {
  font-size: 16px;
}

.card-header button {
  text-decoration: none;
  color: #000;
}
</style>
<style>
    .m-auto float-right{
        border-bottom: 3px double;
    }
</style>
@section('content')
<hr>
<span  class="m-auto float-right"> WELCOME:- {{ Auth::user()->employee->name }} &nbsp; <a class="badge badge badge-info" style="font-size:14px;" href="/logout" class="">Logout</a></span><br>
<div id="accordion" >
    <div class="card mb-0" style="border-radius:1%; border-left-color: #0067b8 !important; border-left-width:2px;">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
            <i class="fa fa-user"> </i>
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              <strong>My Profile<strong>
            </button>
        </h5>
      </div>
  
<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
<div class="card-body">
 <div class="row">
     <div class="card col-md-12 mb-2" style="border-radius:0%; border-top-color: #0067b8 !important; border-top-width:3px;">
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
                                               <label for="">{{$employee->name ?? '-' }}</label>
           
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""> </label>
                                               <label for=""> [ {{$employee->first_name_am ?? '-' }}
                                                   {{$employee?->father_name_am ?? '-' }}
                                                   {{$employee?->grand_father_name_am ?? '-' }}]
           
                                               </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Job title : </b></label>
                                               <label for="">{{$employee->position->name ?? '-' }}</label>
                                           </div>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Educational level : </b></label>
                                               <label for="">{{$employee->educationLevel->name ?? '-' }}</label>
                                           </div>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Phone Number : </b></label>
                                               <label for="">{{$employee->phone_number ?? '-' }}</label>
                                           </div>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Ethnicity : </b></label>
                                               <label for="">{{$employee->ethnicity->name ?? '-' }}</label>
                                           </div>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Religion : </b></label>
                                               <label for="">{{$employee->religion->name ?? '-' }}</label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Last Efficinecy : </b></label>
                                               <label for="">{{ $mark ?? '-' }}%</label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Job grade: </b></label>
                                               <label for=""> {{$employee->position->jobTitle->level->name ?? '-' }}
                                               </label>
                                           </div>
           
           
           
           
           
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Horizonat Level: </b></label>
                                               <label for="">
           
                                                   @if ($employee->horizontal_level == 1)
                                                       {{$employee->horizontal_level }} <sup>st</sup>
                                                   @elseif($employee->horizontal_level == 2)
                                                       {{$employee->horizontal_level }} <sup>nd</sup>
                                                   @elseif($employee->horizontal_level == 3)
                                                       {{$employee->horizontal_level }} <sup>rd</sup>
                                                   @elseif($employee->horizontal_level >= 4 and $employee->horizontal_level <= 9)
                                                       {{$employee->horizontal_level }} <sup>th</sup>
                                                   @else
                                                       {{$employee->horizontal_level }}
                                                   @endif
                                               </label>
           
                                           </div>
           
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Job Position Code : </b></label>
                                               <label for=""> {{$employee->positionCode?->code ?? '-' }} </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Nationality: </b></label>
                                               <label for=""> {{$employee->nationality->nation ?? '-' }} </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Experience : </b></label>
                                               <label for=""
                                                   title="Hired date: {{$employee->employement_date->format('d/m/Y') ?? '-' }} ">
                                                   {{$employee->getEmployementDateRange() }}
                                               </label>
                                           </div>
                                           @if ($employee->employment_status_id == 1)
                                               <div class="d-flex justify-content-between">
                                                   <label for=""><b> Retirement ends after: </b></label>
                                                   <label for="">
                                                       <span style="color:red;">
                                                           <span id="counter" class="text-center"></span>
                                                   </label>
                                               </div>
                                           @endif
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Under Probation Period: </b></label>
                                               <label for=""> {{ '' }} </label>
                                               {{-- <label for=""> {{ $status }} </label> --}}
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> HR Office: </b></label>
                                               <label for=""> {{$employee->hrBranch?->name ?? '-' }} </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> National ID: </b></label>
                                               <label for=""> {{$employee->national_id ?? '-' }} </label>
                                           </div>
                                       </div>
                                      
           
           
                                       <div class="col-md-6" style="border-left:1px solid black;">
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Gender : </b></label>
                                               <label for="">{{$employee->gender ?? '-' }}</label>
                                           </div>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Blood group : </b> </label>
                                               <label for="">{{$employee->blood_group ?? '-' }}</label>
                                           </div>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Email : </b></label>
                                               <label for="">{{$employee->email ?? '-' }}</label>
                                           </div>
           
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Date of Permanent: </b></label>
                                               <label for=""> {{$employee->employement_date->format('d/m/Y') }} E.C
                                               </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Marital status : </b></label>
                                               <label for="">{{$employee?->maritalStatus->name ?? '-' }}</label>
                                           </div>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Employee ID Number : </b></label>
                                               <label for="">{{$employee->employmeent_identity ?? '-' }}</label>
                                           </div>
           
                                           <style>
                                               #sal {
                                                   border-bottom: 3px double;
                                               }
                                           </style>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Gross Salary : </b></label>
                                               <label id="sal" for=""> ETB {{ number_format($startSalary, 2) ?? '-' }}
                                               </label>
                                               {{-- <label for=""> ETB {{ number_format($crud->entry->salaryStep->jobGrade->start_salary,2) }}</label> --}}
                                           </div>
           
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Employement type : </b></label>
                                               <label for=""> {{$employee->employmentType->name ?? '-' }} </label>
                                           </div>
           
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Employee type : </b></label>
                                               <label for=""> {{$employee->employeeCategory->name ?? '-' }} staff
                                               </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Place of Birth : </b></label>
                                               <label for=""> {{$employee?->birth_city }} </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Working office : </b></label>
                                               <label for=""> {{$employee->position->unit->name ?? '-' }} </label>
                                           </div>
           
           
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Field of study : </b></label>
                                               <label for=""> {{$employee?->fieldOfStudy->name ?? '-' }} </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Employee title : </b></label>
                                               <label for=""> {{$employee->employeeTitle->title ?? '-' }}. </label>
                                           </div>
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Pention number: </b></label>
                                               <label for=""> {{$employee->pention_number ?? '-' }} </label>
                                           </div>
           
           
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b>Date of birth :</b></label>
                                               <label for=""
                                                   title="{{ \Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }} ">
           
                                                   {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d/m/Y') ?? '-' }}
                                                   ({{$employee->age() }} years old)
                                               </label>
           
           
                                           </div>
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> Current status : </b></label>
                                               <label for=""> {{$employee->employmentStatus->name ?? '-' }} </label>
                                           </div>
           
           
           
                                           <div class="d-flex justify-content-between">
                                               <label for=""><b> CBE Account: </b></label>
                                               <label for=""> {{$employee->cbe_account ?? '-' }} </label>
                                           </div>
           
           
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
        </div>
      </div>
    </div>

    <div class="card mb-0 mt-1" style="border-radius:1%; border-left-color: #0067b8 !important; border-left-width:2px;">
      <div class="card-header" id="headingTwo">

        <h5 class="mb-0">
            <i class="fa fa-book"> </i>
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
           <strong> Other Information </strong>

          </button>
        </h5>
      </div>

      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
        <h6 class="card-title">1) Effiency List </h6>
    
                <table class="table table-bordered table-hover table-responsive-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Term of evalution </th>
                                    <th>Total Point</th>
                                    <th>Inserted by</th>

                                    <th>Is approved</th>
                                    <th>Approved by </th>
                                    <th>Date of created </th>




                                
                                </tr>
                            </thead>
                            <tbody>
                             

                                @foreach ($employee->evaluations as $evaluation)
                                    <tr>
                                        <td>{{ $evaluation->quarter->name ?? '-' }}</td>
                                        <td>{{ $evaluation->total_mark ?? '-' }}</td>
                                        <td>{{ $evaluation->createdBy->name ?? '-' }}</td>
                                        <td>
                       
                                            @if ($evaluation->isApproved == 1)
                                                <i class="fa fa-check-square" aria-hidden="true"></i>
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td>
                                            @if ($evaluation->isApproved == 1)
                                                {{ $evaluation->approval->name ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>


                                        <td>{{ $evaluation->created_at->format('d-m-Y') }} E.C </td>
                                       
                    
                                    </tr>
                                @endforeach
                                @if($employee->evaluations->count() == 0)
                                    <tr>
                                        <td colspan="7" class="text-left" style="color:red;">No Employee Efficiency
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <hr>
                        <h6 class="card-title">2) Employee Education </h6>
                        <table class="table table-bordered table-hover table-responsive-sm">
                            <thead class="thead-light">
                            <tr>
                                <th>Education Level</th>
                                <th>Institution</th>
                                <th>Field of Study</th>
                                <th>Duration</th>
                                <th>Upoads</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employee->employeeEducations as $employeeEducation)
                                <tr>

                                    <td>{{ $employeeEducation->educationalLevel->name ?? '-' }}</td>
                                    <td>{{ $employeeEducation?->institution ?? '-' }}</td>
                                    <td>{{ $employeeEducation->fieldOfStudy->name ?? '-' }}</td>
                                    <td>{{ $employeeEducation->training_start_date->format('s-m-Y') }} E.C -
                                        {{ $employeeEducation->training_end_date->format('d-m-Y') }} E.C</td>

                                    <td><a href="{{ $employeeEducation->upload ?? '-' }}" target="_blank">View
                                            Document</a>
                                    </td>


                                </tr>
                            @endforeach
                            @if($employee->employeeEducations->count() == 0)
                                <tr>
                                    <td colspan="6" class="text-left" style="color:red;">Empty Employee education found!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <hr>

                    <h6 class="card-title">3) Internal Experience </h6>
                    <table class="table table-bordered table-hover table-responsive-sm">
                        <thead class="thead-light">
                        <tr>
                            <th>Working unit </th>
                            <th>Job Title</th>
                            <th> Employmet type </th>
                            <th>Service year </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($employee->internalExperiences as $internalExperience)
                            <tr>
                                <td>{{ $internalExperience->unit?->name }}</td>
                                <td>{{ $internalExperience->jobTitle?->name }}</td>
                                <td>{{ $internalExperience->employmentType->name ?? '-' }}</td>
                                <td> From {{ $internalExperience->start_date->format('d-m-Y') }} -
                                    {{ $internalExperience->end_date?->format('d-m-Y') ?? 'Now' }} E.C</td>
                               

                            </tr>
                        @endforeach
                        @if (count($employee->internalExperiences ) == 0)
                            <tr>
                                <td colspan="6" class="text-left" style="color:red;">Empty Internal Experience
                                    found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <hr>
                <h6 class="card-title"> 4) External Experience </h6>

              
                
                <table class="table table-bordered table-hover table-responsive-sm">
                    <thead class="thead-light">
                    <tr>
                        <th>Company Name</th>
                        <th>Job Title</th>
                        <th>Employeemet type </th>
                        <th>Service Year</th>

                     
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee->externalExperiences as $externalExperience)
                        <tr>
                            {{-- <td>{{ $externalExperience-> }}</td> --}}
                            <td>{{ $externalExperience->company_name }}</td>
                            <td>{{ $externalExperience->job_title_id }} </td>
                            <td>{{ $externalExperience->employmentType->name ?? '-' }}</td>
                            <td>From {{ $externalExperience->start_date->format('d-m-Y') }} -
                                {{ $externalExperience->end_date->format('d-m-Y') }} E.C</td>

                           
                        </tr>
                    @endforeach
                    @if (count($employee->externalExperiences) == 0)
                        <tr>
                            <td colspan="7" class="text-left" style="color:red;">No External Experience
                                found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>          
      </div>
    </div>



    <div class="card mb-0 mt-1"style="border-radius:1%; border-left-color: #0067b8 !important; border-left-width:2px;">
      <div class="card-header" id="headingThree">
        <h5 class="mb-0">
            <i class="fa fa-list"> </i>
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <strong> Open Postions </strong>
          </button>
        </h5>
      </div>
      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
      -
        </div>
      </div>
    </div>

    <div class="card mt-1"style="border-radius:1%; border-left-color: #0067b8 !important; border-left-width:2px;">
        <div class="card-header" id="headingFour">
          <h5 class="mb-0">
              <i class="fa fa-envelope"> </i>
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          <strong> Miscellaneous Applications </strong>
            </button>
          </h5>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
          <div class="card-body">
    
            <h6 class="card-title"> Application History </h6>
            <div class="">

                @canany(['application.icrud', 'application.create'])
                    <a href="" class="btn btn-outline-primary btn-sm float-right mb-1">
                        <i class="fa fa-plus"></i> Send </a>
                @endcanany
            </div>
            <table class="table table-bordered table-hover table-responsive-sm">
                <thead class="thead-light">
                <tr>
                    <th>Employee </th>
                    <th> Request</th>
                    <th> Status </th>
                    <th>Date of submitted </th>
                    <th> File </th>
                </tr>
            </thead>

            <tbody>
                @foreach (Auth::user()->applications as $application)
                    <tr>
                        <td>{{ $application->user->employee->name }}</td>
                        <td>{{ $application->applicationType->name }}</td>
                        <td>{{ $application->status ?? '-' }}</td>
                        <td>  {{ $application->created_at }} E.C</td>
                        <td> 
                            @if( $application->status== 1)
                            <a href="#"> <span class="fa fa-download"> Download</span> </a>
                        
                        @else
                        -
                        @endif 
                        </td>
                    
                    </tr>
                @endforeach
                @if (Auth::user()->applications->count() == 0)
                    <tr>
                        <td colspan="6" class="text-left" style="color:red;"> No application found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <hr>

          </div>
        </div>
      </div>
  </div>
    @if ($placementRound != null)
        <div class="row">
            <div class="card col-md-12 mb-2"
                style="border-radius:0%; border-top-color:  #0067b8 !important; border-top-width:2px;">
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
                            <div class="col-md-12">
                                <button class="btn btn-outline-primary btn-sm float-right mb-1">Save Choice</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
