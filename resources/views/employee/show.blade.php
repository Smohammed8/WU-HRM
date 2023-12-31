@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.min.css') }}" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/calendar/css/redmond.calendars.picker.css') }}" />


{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}

<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.1/howler.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/webcam.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/howler.min.js') }}"></script>
<script src="{{ asset('assets/js/axios.min.js') }}"></script>


<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">

<style type="text/css">
    #results {
        padding: 2px;
        border: 0px solid;
        background: white;
        width: 50%;
        height: 50%;
        object-fit: cover;

    }

    .after_capture_frame {
        height: 200px;
        width: 200px;
        border-width: 4px;
        /* Adjust this value to control the thickness of the border */
        border-style: double;
        border-color: #000;
        /* Adjust the color as needed */
        padding: 10px;
        /* Optional padding to create space between the image and the border */


    }

    .photo {
        border-width: 4px;
        /* Adjust this value to control the thickness of the border */
        border-style: double;
        border-color: #000;
        /* Adjust the color as needed */
        padding: 10px;
        /* Optional padding to create space between the image and the border */

    }
</style>



@section('header')
    <section class="container-fluid d-print-none">

        <div class="d-none d-md-block">
            @canany('employee.index')
                <a href="{{ route('employee.index') }}" class="btn  btn-sm btn-outline-primary float-right mr-1"><i
                        class="la  la-search"></i> Search
                </a>
            @endcanany


            <button class="btn  btn-sm btn-outline-primary float-right mr-1 toggle-status"
                data-employee-id="{{ $crud->entry->rfid }}">
                {{ $crud->entry->rfid ? 'Active' : 'Toggle' }}
            </button>



            @canany('employee.edit')
                <a href="{{ route('employee.edit', ['id' => $crud->entry?->id]) }}"
                    class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la  la-edit"></i> Edit
                </a>
            @endcanany

            @canany(['employee.efficency.icrud', 'employee.efficency.index'])
                @if ($ep != null)
                    @if ($ep == 'On')
                        <button type="button" data-toggle="modal" data-target="#efficiency" target="_top"
                            class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la  la-balance-scale"></i>
                            Efficiency
                        </button>
                    @else
                        -
                    @endif
                @else
                    <button type="button" data-toggle="modal" data-target="#" target="_top"
                        class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la  la-balance-scale"></i><del>
                            Efficiency
                        </del>
                    </button>
                @endif
            @endcanany

            @canany(['employee.leave.icrud', 'employee.leave.index'])
                <button type="button" data-toggle="modal" data-target="#employee_leave" target="_top"
                    class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-user-minus"></i> Leave</button>
            @endcanany

            @canany(['employee.discipline.icrud', 'employee.discipline.index'])
                <button type="button" data-toggle="modal" data-target="#decipline" target="_top"
                    class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-exclamation-circle"></i>
                    Discipline</button>
            @endcanany

            @canany(['employee.promotion.icrud', 'employee.promotion.index'])
                <button type="button" data-toggle="modal" data-target="#promotion" target="_self"
                    class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-arrow-up"></i> Promotion</button>
            @endcanany

            @canany(['employee.demotion.icrud', 'employee.demotion.index'])
                <button type="button" data-toggle="modal" data-target="#demotion" target="_self"
                    class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-arrow-down"></i> Demotion</button>
            @endcanany



             
       
          


            {{-- <button type="button" data-toggle="modal" data-target="#back" target="_top"
            class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-user-plus"></i> Attendance </button> --}}
            <form method="POST" id="myForm" action="{{ route('id.download') }}">
                @csrf
                <input type="hidden" id="htmlValue" value="{{ $crud->entry?->id }}" name="user_id">
                <input type="hidden" id="qrValue" name="qrValue">
                <input type="hidden" id="barValue" name="barValue">
            </form>

            @if ($crud->entry?->photo and $crud->entry->position?->jobTitle)
                @can('employee.id.print')
                    <a href="#" onclick="printID();" class="btn  btn-sm btn-outline-primary float-right mr-1">
                        <i class="la la-exclamation-circle"></i>
                        Print ID
                    </a>
                @endcan
            @endif


            @if ($crud->entry->position?->jobTitle)
                @canany('hire.letter.print')
                    <a href="{{ route('hire.letter', ['employee_id' => $crud->entry->id]) }}"
                        class="btn  btn-sm btn-outline-primary float-right mr-1">
                        <i class="la la-book"></i>
                        Hire Letter
                    </a>
                @endcanany
            @endif

            @if ($crud->entry->internalExperiences->count() > 0)
                @canany('experience.letter.print')
                    <a href="#" class="btn  btn-sm btn-outline-primary float-right mr-1">
                        <i class="la la-calendar"></i>
                        Exp.Letter
                    </a>
                @endcanany
            @endif

            <button type="button"
            class="btn  btn-sm btn-primary float-right mr-1">FN: {{ $crud->entry->file_number ?? "-" }}
        </button>

        </div>
        {{-- @endcan --}}
        {{-- <a href="javascript: window.print();" class="btn  btn-sm btn-outline-primary float-right"><i
            class="la la-print"></i></a> --}}

        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')) . ' ' . $crud->entity_name !!}.</small>
            @if ($crud->hasAccess('list'))
                <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i
                            class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span></a>
                </small>
            @endif
        </h2>
    </section>

    <script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
    <script src="{{ asset('assets/js/JsBarcode.all.min.js') }}"></script>
    <script>
        var DATAS = [];
        var obj = [];
        var objBarCode = [];
        @can('employee.id.print')


            function printID() {
                var id_number = '12345';
                var div__qr_img = document.createElement("div");

                var div__qr_img_2 = document.createElement("div");

                var qrcode = new QRCode(div__qr_img, {
                    text: id_number,
                    width: 130,
                    height: 130,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H,
                });

                var img = qrcode._el.children[1];
                var src = div__qr_img.children[0].toDataURL("image/png");

                var div__bar_img = document.createElement("img");

                JsBarcode(div__bar_img, id_number, {
                    lineColor: "black",
                    width: 1.5,
                    height: 20,
                    displayValue: true,
                    fontSize: "13px",
                    textPosition: "top"
                });
                // JsBarcode(div__bar_img)
                //     .options({font: "OCR-B", displayValue: false, width:5, height: 50})
                //     .EAN5(kebele_resident.id+"2015", {fontSize: 20, textMargin: 0})
                //     .render();

                document.getElementById('qrValue').value = src;
                document.getElementById('barValue').value = div__bar_img.src;
                document.getElementById("myForm").submit();
            }
        @endcan
    </script>



@endsection

<style>
    #image {
        max-width: 200%;
        /* Make the image responsive */
        height: auto;
        /* Allow the image to scale proportionally */
        display: block;
        /* Remove any extra spacing or borders around the image */
    }
</style>
@section('content')
    <div class="row">
        <div class=" card col-md-12 mb-2 card card-primary card-outline">

            <div class="card-body" style="font-family:inherit; font-size:14px;">
                <div class="row">
                    <div class="col-md-2" style="border-right:1px solid black;">
                        <div id="results">

                            <img src="{{ $crud->entry?->photo }}" id="image" class="after_capture_frame img-fluid"
                                alt="profile Pic" height="220" width="200">
                                 
                        </div>
                     
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button id="openCamera" onClick="openCamera()"
                                    class="btn  btn-sm btn-outline-primary float-left mr-1 mt-0"> <i class="fa fa-camera"
                                        aria-hidden="true"></i> On </button>
                                <input type="button" id="openButton" value="Capture" onClick="take_snapshot()"
                                    class="btn btn-sm btn-outline-primary float-left mr-1 mt-0">
                                <form method="POST" id="myForm" enctype="multipart/form-data"
                                    action="{{ route('webcam.capture') }}">

                                    @csrf
                                    <button type="button" data-value="{{ $crud->entry->id }}" id="save"
                                        class="btn  btn-sm btn-outline-primary float-left mr-1 mt-0" onclick="saveSnap()">
                                        <i class="fa fa-upload" aria-hidden="true"></i> Save</button>

                                    <input type="hidden" name="image" accept="image/*" id="captured_image_data"
                                        class="image-tag">
                                </form>
                            </div>
                            <div id="my_camera" class="pre_capture_frame"> </div>

                            <div class="card">
                            </div>

                        </div>


                        <script>
                            // Configure a few settings and attach camera 250x187
                            const button = document.getElementById('save');
                            const entryId = button.getAttribute('data-value');
                            Webcam.set({
                                width: 200,
                                height: 300,
                                image_format: 'jpeg',
                                jpeg_quality: 100,
                                flip_horiz: true

                            });

                            // Toggle the camera on and off when the "Open Camera" button is clicked
                            function openCamera() {
                                if (Webcam.loaded) {
                                    // Camera is on, turn it off
                                    // Webcam.detach('#my_camera');
                                    Webcam.reset();
                                    // Change the button text to "On"
                                    document.getElementById('openCamera').innerHTML = '<i class="fa fa-camera" aria-hidden="true"></i> On';

                                    var myDiv = document.getElementById('me');
                                    var myButton = document.getElementById('openCamera');
                                    myButton.addEventListener('click', function() {
                                        myDiv.style.display = 'none';
                                    });
                                } else {
                                    // Camera is off, turn it on
                                    Webcam.attach('#my_camera');
                                    // Change the button text to "Off"
                                    document.getElementById('openCamera').innerHTML = '<i class="fa fa-camera" aria-hidden="true"></i> Off';
                                }
                            }

                            function take_snapshot() {
                                // Attach the camera to the element with the ID #my_camera
                                if (!Webcam.loaded) {

                                    alert('Camera is not attached. Click "On" to open the camera !');
                                }

                                // Take snapshot and get image data
                                Webcam.snap(function(data_uri) {
                                    $(".image-tag").val(data_uri);
                                    document.getElementById('results').innerHTML = '<img class="after_capture_frame" src="' + data_uri +
                                        '"/>';
                                    document.getElementById('captured_image_data').value = data_uri;
                                    // shutterSound.play();
                                });
                            }

                            // Save the captured image to the server


                            // Save the captured image to the server
                            function saveSnap() {


                                var base64data = document.getElementById('captured_image_data').value;

                                if (base64data) {
                                    axios.post('/webcam', {
                                            image: base64data,
                                            employeeId: entryId
                                        })

                                        .then(function(response) {
                                            const currentUrl = window.location.href;
                                            const match = currentUrl.match(/\/employee\/(\d+)\/show/);

                                            if (response.status === 200) {
                                                // Add a pop-up success message
                                                alert('Image saved successfully!');
                                                console.log('Image saved successfully:', response.data);

                                                window.location.href = `https://hrm.ju.edu.et/employee/{entryId}/show`;
                                               //  window.location.href = `http://127.0.0.1:8000/employee/${entryId}/show`;
                                                Webcam.reset();
                                            } else {
                                                console.error('Error saving image:', response.data);
                                            }
                                        })
                                        .catch(function(error) {
                                            console.error('Error saving image:', error);
                                        });
                                } else {
                                    console.error('No base64 data found in given ID element');
                                }

                            }
                            saveSnap();
                        </script>



                        <div id="me">
                            @if ($user_id !== null)
                                <hr>
                                <span style="color:green"> <b>UAS Account is Mapped</b> </span><br>

                                <i class='fa fa-caret-right'></i> Username: <u>{{ $username ?? '' }}</u><br>
                                <i class='fa fa-caret-right'></i> Role :
                                @foreach ($roles as $role)
                                    {{ $role }}
                                @endforeach
                            @else
                            @endif
                            <hr>
                            <i class='fa fa-caret-right'></i> Total Leave days: - {{ $remainingLeaveDays }} days <br>
                            <i class='fa fa-caret-right'></i> Remaining Leave days: - {{ $remainingLeaveDays }} days <br>
                            <i class='fa fa-caret-right'></i> Experience taken: - 0 times <br>
                            <i class='fa fa-caret-right'></i> Number of families: - {{ $crud->entry->families->count() }}
                            <br>
                            <hr>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Employee Name : </b> </label>
                                    <label for="">{{ $crud->entry->name ?? '-' }}</label>

                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""> </label>
                                    <label for=""> [ {{ $crud->entry->first_name_am ?? '-' }}
                                        {{ $crud->entry?->father_name_am ?? '-' }}
                                        {{ $crud->entry?->grand_father_name_am ?? '-' }}]

                                    </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Job title : </b></label>
                                    <label for="">{{ $crud->entry->position->name ?? '-' }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Educational level : </b></label>
                                    <label for="">{{ $crud->entry->educationLevel->name ?? '-' }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Phone Number : </b></label>
                                    <label for="">{{ $crud->entry->phone_number ?? '-' }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Ethnicity : </b></label>
                                    <label for="">{{ $crud->entry->ethnicity->name ?? '-' }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Religion : </b></label>
                                    <label for="">{{ $crud->entry->religion->name ?? '-' }}</label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Last Efficinecy : </b></label>
                                    <label for="">{{ $mark ?? '-' }}%</label>
                                </div>

                                {{-- <div class="d-flex justify-content-between">
                                    <label for=""><b>Last Efficinecy : </b></label>
                                    <label for="">{{ $crud->entry->evaluations->emoloyee_id }} %</label>
                                </div> --}}



                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Job grade: </b></label>
                                    <label for=""> {{ $crud->entry->position->jobTitle->level->name ?? '-' }}
                                    </label>
                                </div>






                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Horizonat Level: </b></label>
                                    <label for="">

                                        @if ($crud->entry->horizontal_level == 1)
                                            {{ $crud->entry->horizontal_level }} <sup>st</sup>
                                        @elseif($crud->entry->horizontal_level == 2)
                                            {{ $crud->entry->horizontal_level }} <sup>nd</sup>
                                        @elseif($crud->entry->horizontal_level == 3)
                                            {{ $crud->entry->horizontal_level }} <sup>rd</sup>
                                        @elseif($crud->entry->horizontal_level >= 4 and $crud->entry->horizontal_level <= 9)
                                            {{ $crud->entry->horizontal_level }} <sup>th</sup>
                                        @else
                                            {{ $crud->entry->horizontal_level }}
                                        @endif
                                    </label>

                                </div>


                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Job Position Code : </b></label>
                                    <label for=""> {{ $crud->entry->positionCode?->code ?? '-' }} </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Nationality: </b></label>
                                    <label for=""> {{ $crud->entry->nationality->nation ?? '-' }} </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Total Experience : </b></label>
                                    <label for=""
                                        title="From date of permanent:     {{ $crud->entry->getEmployementDateRange() }} ">
                                        {{-- {{ $crud->entry->getEmployementDateRange() }} --}}

                                     
                                      @if($crud->entry->internalExperiences->count() > 0 or $crud->entry->externalExperiences->count() > 0)

                                        {{ $crud->entry->totalExperiences()['years'] }} years
                                        {{ $crud->entry->totalExperiences()['months'] }} months
                                        {{ $crud->entry->totalExperiences()['days'] }} days
                                        @else
                                        {{ $crud->entry->getEmployementDateRange() }}

                                        @endif
                                  
                                    </label>
                                </div>
                                @if ($crud->entry->employment_status_id == 1)
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
                                    <label for=""> {{ $status }} </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b> HR Office: </b></label>
                                    <label for=""> {{ $crud->entry->hrBranch?->name ?? '-' }} </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b> National ID: </b></label>
                                    <label for=""> {{ $crud->entry->national_id ?? '-' }} </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Address[RZWK]: </b></label>
                                    <label for="">
                                        {{ $crud->entry->region->name ?? '-' }} /
                                        {{ $crud->entry->zone->name ?? '-' }} /
                                        {{ $crud->entry->woreda->name ?? '-' }} /
                                        {{ $crud->entry->kebele->name ?? '-' }} </label>
                                </div>


                            </div>
                            {{-- {{  $date_of_retire2  }} --}}
                            <div id="retirement-date" data-date="<?php echo $date_of_retire2; ?>"></div>
                            <script>
                                var retirementDate = new Date(document.getElementById("retirement-date").dataset.date).getTime();
                                // var retirementDate = new Date("<?php echo "$date_of_retire2"; ?>").getTime();

                                // Function to update the countdown timer
                                function updateCountdown() {
                                    var currentTime = new Date().getTime();
                                    var timeDifference = retirementDate - currentTime;

                                    if (timeDifference < 0) {
                                        clearInterval(interval);
                                        document.getElementById("counter").innerHTML = "Employee Retired";
                                        return;
                                    }

                                    var year = Math.floor(timeDifference / (1000 * 60 * 60 * 24 * 365));
                                    var month = Math.floor(timeDifference / (1000 * 60 * 60 * 24 * 30) % 12);
                                    var days = Math.floor((timeDifference / (1000 * 60 * 60 * 24)) % 30);
                                    var hours = Math.floor((timeDifference / (1000 * 60 * 60) % 24));
                                    var minutes = Math.floor((timeDifference / (1000 * 60) % 60));
                                    var seconds = Math.floor((timeDifference / 1000 % 60));

                                    var countdownText = year + " years, " + month + " months, " + days + " days, " + hours + " Hr, " + minutes +
                                        " Min, and " + seconds + " s";
                                    document.getElementById("counter").innerHTML = countdownText;
                                }


                                // Initial update
                                updateCountdown();

                                // Update the countdown every 1 second
                                var interval = setInterval(updateCountdown, 1000);
                            </script>


                            <div class="col-md-6" style="border-left:1px solid black;">

                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Gender : </b></label>
                                    <label for="">{{ $crud->entry->gender ?? '-' }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Blood group : </b> </label>
                                    <label for="">{{ $crud->entry->blood_group ?? '-' }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Email : </b></label>
                                    <label for="">{{ $crud->entry->email ?? '-' }}</label>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Date of Permanent: </b></label>
                                    <label for=""> {{ $crud->entry->employement_date->format('d/m/Y') }} E.C
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Marital status : </b></label>
                                    <label for="">{{ $crud->entry?->maritalStatus->name ?? '-' }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Employee ID Number : </b></label>
                                    <label for="">{{ $crud->entry->employmeent_identity ?? '-' }}</label>
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
                                    <label for=""> {{ $crud->entry->employmentType->name ?? '-' }} </label>
                                </div>


                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Employee type : </b></label>
                                    <label for="">
                                        @if ($crud->entry->employee_sub_category_id == null)
                                            {{ $crud->entry->employeeCategory->name ?? '-' }}
                                        @else
                                            {{ $crud->entry->employeeCategory->name ?? '-' }} -
                                            {{ $crud->entry->employeeSubCategory->name ?? '-' }}
                                        @endif

                                    </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Place of Birth : </b></label>
                                    <label for=""> {{ $crud->entry?->birth_city }} </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Working office : </b></label>
                                    <label for=""> {{ $crud->entry->position->unit->name ?? '-' }} </label>
                                </div>



                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Field of study : </b></label>
                                    <label for=""> {{ $crud->entry?->fieldOfStudy->name ?? '-' }} </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Employee title : </b></label>
                                    <label for=""> {{ $crud->entry->employeeTitle->title ?? '-' }}. </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Pention number: </b></label>
                                    <label for=""> {{ $crud->entry->pention_number ?? '-' }} </label>
                                </div>



                                <div class="d-flex justify-content-between">
                                    <label for=""><b>Age :</b></label>
                                    <label for=""
                                        title="{{ \Carbon\Carbon::parse($crud->entry->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }} ">

                                        {{ \Carbon\Carbon::parse($crud->entry->date_of_birth)->format('d/m/Y') ?? '-' }}
                                        ({{ $crud->entry->age() }} years old)
                                    </label>


                                </div>
                                <div class="d-flex justify-content-between">
                                    <label for=""><b> Current status : </b></label>
                                    <label for=""> {{ $crud->entry->employmentStatus->name ?? '-' }} </label>
                                </div>



                                <div class="d-flex justify-content-between">
                                    <label for=""><b> CBE Account: </b></label>
                                    <label for=""> {{ $crud->entry->cbe_account ?? '-' }} </label>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>

    </div>

    <div class="d-none d-md-block"> <!-- hide on mobile device -->

        <div class="tab-container mb-2 row">
            <div class="nav-tabs-custom p-0 d-flex  col-md-12" id="form_tabs">
                <div class="col-md-2  p-1 m-1">
                    <ul class="nav nav-tabs nav-stacked flex-column " role="tablist">

                        @canany(['employee.emergency-contact.icrud', 'employee.emergency-contact.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_contact" aria-controls="" role="tab"
                                    tab_name="tab_employee_contact" data-toggle="tab" class="nav-link active">
                                    <i class="la la la-user" style="font-size: 20px;"> </i>&nbsp;
                                    {{ 'Emergency Contact' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.education.icrud', 'employee.education.icrud.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_education" aria-controls="tab_employee_education" role="tab"
                                    tab_name="employee_education" data-toggle="tab" class="nav-link "> <i
                                        class="la la-graduation-cap" style="font-size: 20px"> </i>
                                    {{ 'Employee Education' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.internal-experience.icrud', 'employee.internal-experience.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_internal_experience" aria-controls="tab_employee_internal_experience"
                                    role="tab" tab_name="employee_internal_experience" data-toggle="tab"
                                    class="nav-link ">
                                    <i class="la la-map" style="font-size: 20px"> </i> {{ 'Internal Experience' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.external-experience.icrud', 'employee.external-experience.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_external_experience" aria-controls="tab_employee_external_experience"
                                    role="tab" tab_name="employee_external_experience" data-toggle="tab"
                                    class="nav-link ">
                                    <i class="la la-flag" style="font-size: 20px"> </i> {{ 'External Experience' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.efficency.icrud', 'employee.efficency.icrud.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_evaluation" aria-controls="tab_employee_evaluation" role="tab"
                                    tab_name="employee_evaluation" data-toggle="tab" class="nav-link "> <i
                                        class="la la-balance-scale" style="font-size: 20px"> </i>
                                    {{ 'Employee Efficiency' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.family.icrud', 'employee.family.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_family" aria-controls="tab_employee_family" role="tab"
                                    tab_name="employee_family" data-toggle="tab" class="nav-link "> <i class="la la-users"
                                        style="font-size: 20px"> </i> {{ 'Employee Families' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.language.icrud', 'employee.language.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_language" aria-controls="tab_employee_language" role="tab"
                                    tab_name="employee_language" data-toggle="tab" class="nav-link "> <i class="la la-globe"
                                        style="font-size: 20px"> </i> {{ 'Language Ability' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.training-study.icrud', 'employee.training-study.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_training_and_experience" aria-controls="tab_training_and_experience"
                                    role="tab" tab_name="training_and_experience" data-toggle="tab" class="nav-link ">
                                    <i class="la la la-check-circle " style="font-size: 20px"> </i>
                                    {{ 'Training and Studies' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.special-skill.icrud', 'employee.special-skill.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_skill" aria-controls="tab_employee_skill" role="tab"
                                    tab_name="tab_employee_skill" data-toggle="tab" class="nav-link"> <i
                                        class="la la-empire" style="font-size: 20px;"> </i>&nbsp; {{ 'Special Skill' }}</a>
                            </li>
                        @endcanany

                        @canany(['employee.license.icrud', 'employee.license.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_licence" aria-controls="tab_employee_licence" role="tab"
                                    tab_name="employee_licence" data-toggle="tab" class="nav-link "> <i class="la la-gavel"
                                        style="font-size: 20px"> </i> {{ 'Employee Licenses' }}</a>
                            </li>
                        @endcanany
                        @canany(['employee.certification.icrud', 'employee.certification.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_certificate" aria-controls="tab_employee_certificate" role="tab"
                                    tab_name="employee_certificate" data-toggle="tab" class="nav-link "> <i
                                        class="la la-book" style="font-size: 20px"> </i>{{ 'Employee Certification' }}</a>
                            </li>
                        @endcanany
                        <li role="presentation" class="nav-item"></li>

                        @canany(['employee.letters.icrud', 'employee.letters.index'])
                            <li role="presentation" class="nav-item">
                                <a href="#tab_employee_letter" aria-controls="tab_employee_letter" role="tab"
                                    tab_name="employee_letter" data-toggle="tab" class="nav-link "> <i class="la la-book"
                                        style="font-size: 20px"> </i> {{ 'Written Letters' }}</a>
                            </li>
                        @endcanany

                    </ul>
                </div>



                <div class="tab-content box m-0 col-md-9 p-0 v-pills-tabContent">

                    <!-- ///////////////////////////////////////////////////////-->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_evaluation">
                        <h4>Employee Efficiancy </h4>
                        <div class="no-padding no-border">
                            <div class="">
                                @canany(['employee.education.icrud', 'employee.education.create'])
                                    <a href="{{ route('{employee}/evaluation.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee evaluation' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Term of evalution </th>
                                        <th>Total Point</th>
                                        <th>Inserted by</th>

                                        <th>Is approved</th>
                                        <th>Approved by </th>
                                        <th>Date of created </th>




                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($evaluations as $evaluation)
                                        <tr>
                                            <td>{{ $evaluation->quarter->name ?? '-' }}</td>
                                            <td>{{ $evaluation->total_mark ?? '-' }}</td>
                                            <td>{{ $evaluation->createdBy->name ?? '-' }}</td>
                                            <td>
                                                {{-- {{  $evaluation->isApproved  == 1 ? 'Approved' : '-' }}
                         --}}
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
                                            <td>
                                                @if ($evaluation->isApproved == 0)
                                                    @canany(['employee.efficency.icrud', 'employee.efficency.icrud.edit'])
                                                        <a href="{{ route('{employee}/evaluation.edit', ['employee' => $crud->entry?->id, 'id' => $evaluation->id]) }}"
                                                            class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                    @endcanany
                                                    @canany(['employee.efficency.icrud', 'employee.efficency.icrud.delete'])
                                                        <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                            data-route="{{ route('{employee}/evaluation.destroy', ['employee' => $crud->entry?->id, 'id' => $evaluation->id]) }}"
                                                            class="btn btn-sm btn-link" data-button-type="delete"><i
                                                                class="la la-trash"></i>
                                                            {{ trans('backpack::crud.delete') }}</a>
                                                    @endcanany
                                                @else
                                                    Closed
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($evaluations ?? []) == 0)
                                        <tr>
                                            <td colspan="7" class="text-left" style="color:red;">No Employee
                                                Efficiency
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $evaluations->links() }}
                            </div>
                        </div>
                    </div>


                    <!--- //////////////////////////////////////////////////////////////// -->


                    <!-- //////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_education">
                        <h4>Employee Education</h4>
                        <div class="no-padding no-border">
                            <div class="">
                                @canany(['employee.education.icrud', 'employee.education.create'])
                                    <a href="{{ route('{employee}/employee-education.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Education' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Education Level</th>
                                        <th>Institution</th>
                                        <th>Field of Study</th>
                                        <th>Duration</th>
                                        <th>Upoads</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeEducations as $employeeEducation)
                                        <tr>

                                            <td>{{ $employeeEducation->educationalLevel->name ?? '-' }}</td>
                                            <td>{{ $employeeEducation?->institution ?? '-' }}</td>
                                            <td>{{ $employeeEducation->fieldOfStudy->name ?? '-' }}</td>
                                            <td>{{ $employeeEducation->training_start_date->format('s-m-Y') }} E.C -
                                                {{ $employeeEducation->training_end_date->format('d-m-Y') }} E.C</td>

                                            <td><a href="{{ $employeeEducation->upload ?? '-' }}" target="_blank">View
                                                    Document</a>
                                            </td>


                                            <td>
                                                @canany(['employee.education.icrud', 'employee.education.edit'])
                                                    <a href="{{ route('{employee}/employee-education.edit', ['employee' => $crud->entry?->id, 'id' => $employeeEducation->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany
                                                @canany(['employee.education.icrud', 'employee.education.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/employee-education.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeEducation->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeEducations ?? []) == 0)
                                        <tr>
                                            <td colspan="6" class="text-left" style="color:red;">No Employee education
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeEducations->links() }}
                            </div>
                        </div>
                    </div>


                    <!--- //////////////////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane active" id="tab_employee_contact">
                        <h3>Emergency Contacts </h3>
                        <div class="no-padding no-border">
                            <div class="">

                                @canany(['employee.emergency-contact.icrud', 'employee.emergency-contact.create'])
                                    <a href="{{ route('{employee}/employee-contact.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Emeregency Contacts' }}</span>
                                    </a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Relation</th>
                                        <th>Contact Name</th>
                                        <th>Contact</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeContacts as $employeeContact)
                                        <tr>
                                            <td>{{ $employeeContact?->contact_type }}</td>
                                            <td>{{ $employeeContact->contact_name }}</td>
                                            <td>{{ $employeeContact->contact }}</td>
                                            <td>
                                                @canany(['employee.emergency-contact.icrud',
                                                    'employee.emergency-contact.edit'])
                                                    <a href="{{ route('{employee}/employee-contact.edit', ['employee' => $crud->entry?->id, 'id' => $employeeContact->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany
                                                @canany(['employee.emergency-contact.icrud',
                                                    'employee.emergency-contact.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/employee-contact.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeContact->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany

                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeContacts) == 0)
                                        <tr>
                                            <td colspan="4" class="text-left" style="color:red;">No emergency contact
                                                found! </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeSkills->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- /////////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_skill">
                        <h3>Employee Skill</h3>
                        <div class="no-padding no-border">
                            <div class="">

                                @canany(['employee.special-skill.icrud', 'employee.special-skill.create'])
                                    <a href="{{ route('{employee}/skill.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Skill' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Skill Type</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeSkills as $employeeSkill)
                                        <tr>
                                            <td>{{ $employeeSkill?->skillType?->name }}</td>
                                            <td>{{ $employeeSkill->name }}</td>
                                            <td>{{ $employeeSkill->level }}</td>
                                            <td>

                                                @canany(['employee.special-skill.icrud', 'employee.special-skill.edit'])
                                                    <a href="{{ route('{employee}/skill.edit', ['employee' => $crud->entry?->id, 'id' => $employeeSkill->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany

                                                @canany(['employee.special-skill.icrud', 'employee.special-skill.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/skill.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeSkill->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeSkills) == 0)
                                        <tr>
                                            <td colspan="4" class="text-left" style="color:red;">No Special skill
                                                found!
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeSkills->links() }}
                            </div>
                        </div>
                    </div>

                    <!--- /////////////////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_licence">
                        <h5>Employee Licence</h5>
                        <div class=" no-padding no-border">
                            <div class="">

                                @canany(['employee.license.icrud', 'employee.license.create'])
                                    <a href="{{ route('{employee}/license.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Licence' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Licence Type</th>
                                        <th>Downloadable File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeLicenses as $employeeLicence)
                                        <tr>
                                            <td>{{ $employeeLicence->licenseType?->name }}</td>
                                            <td><a href="{{ $employeeLicence->license_file }}" target="_blank">Download
                                                    Document</a>
                                            </td>
                                            <td>

                                                @canany(['employee.license.icrud', 'employee.license.edit'])
                                                    <a href="{{ route('{employee}/license.edit', ['employee' => $crud->entry?->id, 'id' => $employeeLicence->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany
                                                @canany(['employee.license.icrud', 'employee.license.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/license.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeLicence->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeLicenses) == 0)
                                        <tr>
                                            <td colspan="3" class="text-left" style="color:red;">No Employee Licence
                                                found1</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeLicenses->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- //////////////////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_certificate">
                        <h5>Employee Certificate</h5>
                        <div class=" no-padding no-border">
                            <div class="">

                                @canany(['employee.certification.icrud', 'employee.certification.create'])
                                    <a href="{{ route('{employee}/employee-certificate.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Certificate' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>

                                        <th>Type</th>
                                        <th>Name</th>
                                        <th> Location </th>
                                        <th> Date of given </th>
                                        <th> Duration(in days) </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeCertificates as $employeeCertificate)
                                        <tr>
                                            <td>{{ $employeeCertificate->certificationType->name ?? '-' }}</td>
                                            <td>{{ $employeeCertificate?->name }}</td>
                                            <td>{{ $employeeCertificate->address }}</td>
                                            <td>{{ $employeeCertificate->certificate_date }}</td>
                                            <td>{{ $employeeCertificate->duration }}</td>

                                            <td>


                                                @canany(['employee.certification.icrud', 'employee.certification.edit'])
                                                    <a href="{{ route('{employee}/employee-certificate.edit', ['employee' => $crud->entry?->id, 'id' => $employeeCertificate->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany

                                                @canany(['employee.certification.icrud', 'employee.certification.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/employee-certificate.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeCertificate->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeCertificates) == 0)
                                        <tr>
                                            <td colspan="6" class="text-left" style="color:red;">No Employee Licence
                                                found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeCertificates->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- /////////////////////////////////////////////////////////////////// -->


                    <!-- //////////////////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_letter">
                        <h5>Employee Letters </h5>
                        <div class=" no-padding no-border">
                            <div class="">

                                @canany(['employee.letters.icrud', 'employee.letters.create'])
                                    <a href="{{ route('{employee}/employee-letter.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Letters ' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>

                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Date of Written </th>
                                        <th>Scan Uploads </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeLetters as $employeeLetter)
                                        <tr>
                                            <td>{{ $employeeLetter->title ?? '-' }}</td>
                                            <td>{{ $employeeLetter?->body ?? '-' }}</td>
                                            <td>{{ $employeeLetter->written_date->format('d-m-Y') ?? '-' }}</td>


                                            <td><a href="{{ $employeeLetter->upload ?? '-' }}" target="_blank">View
                                                    Document </a>
                                            </td>


                                            <td>


                                                @canany(['employee.letters.icrud', 'employee.letters.icrud.edit'])
                                                    <a href="{{ route('{employee}/employee-letter.edit', ['employee' => $crud->entry?->id, 'id' => $employeeLetter->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany

                                                @canany(['employee.letters.icrud', 'employee.letters.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/employee-letter.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeLetter->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}
                                                    </a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeLetters) == 0)
                                        <tr>
                                            <td colspan="5" class="text-left" style="color:red;">No employee letter
                                                found!
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeLetters->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- /////////////////////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_contact">
                        <h5>Emergency Contact</h5>
                        <div class=" no-padding no-border">
                            <div class="">

                                @canany(['employee.emergency-contact.icrud', 'employee.emergency-contact.create'])
                                    <a href="{{ route('{employee}/employee-contact.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Contact' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Contact Name</th>
                                        <th>Contact Type</th>
                                        <th>Contact</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeContacts as $employeeContact)
                                        <tr>
                                            <td>{{ $employeeContact->contact_name }}</td>
                                            <td>{{ $employeeContact->contact_type }}</td>
                                            <td>{{ $employeeContact->contact }}</td>
                                            <td>

                                                @canany(['employee.emergency-contact.icrud',
                                                    'employee.emergency-contact.edit'])
                                                    <a href="{{ route('{employee}/employee-contact.edit', ['employee' => $crud->entry?->id, 'id' => $employeeContact->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany

                                                @canany(['employee.emergency-contact.icrud',
                                                    'employee.emergency-contact.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/employee-contact.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeContact->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeContacts) == 0)
                                        <tr>
                                            <td colspan="3" class="text-center">No Emeregency Contact found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeContacts->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- //////////////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_language">
                        <h5>Employee Languages</h5>
                        <div class=" no-padding no-border">
                            <div class="">

                                @canany(['employee.language.icrud', 'employee.language.create'])
                                    <a href="{{ route('{employee}/employee-language.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Langauge' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Langauge</th>
                                        <th>Speaking</th>
                                        <th>Reading</th>
                                        <th>Writing</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeLanguages as $employeeLanguage)
                                        <tr>
                                            <td>{{ $employeeLanguage->language?->name }}</td>
                                            <td>{{ $employeeLanguage->speaking }}</td>
                                            <td>{{ $employeeLanguage->reading }}</td>
                                            <td>{{ $employeeLanguage->writing }}</td>
                                            <td>


                                                @canany(['employee.language.icrud', 'employee.language.edit'])
                                                    <a href="{{ route('{employee}/employee-language.edit', ['employee' => $crud->entry?->id, 'id' => $employeeLanguage->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany

                                                @canany(['employee.language.icrud', 'employee.language.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/employee-language.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeLanguage->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeLanguages) == 0)
                                        <tr>
                                            <td colspan="5" class="text-left" style="color:red;">No Employee Language
                                                found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeLanguages->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- /////////////////////////////////////////////////////////////////// -->
                    <div role="tabpanel" class="tab-pane" id="tab_employee_family">
                        <h5>Employee Families</h5>
                        <div class=" no-padding no-border">
                            <div class="">
                                @canany(['employee.family.icrud', 'employee.family.create'])
                                    <a href="{{ route('{employee}/employee-family.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Family' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Family Name</th>
                                        <th>Family Relation</th>
                                        <th>Gender</th>
                                        <th>Date of Birth</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employeeFamilies as $employeeFamily)
                                        <tr>
                                            <td>{{ $employeeFamily?->name }}</td>
                                            <td>{{ $employeeFamily->familyRelationship?->name }}</td>
                                            <td>{{ $employeeFamily->gender }}</td>
                                            <td>{{ $employeeFamily->dob ?? 'Not Specified' }}</td>
                                            <td>
                                                @canany(['employee.family.icrud', 'employee.family.edit'])
                                                    <a href="{{ route('{employee}/employee-family.edit', ['employee' => $crud->entry?->id, 'id' => $employeeFamily->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany
                                                @canany(['employee.family.icrud', 'employee.family.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/employee-family.destroy', ['employee' => $crud->entry?->id, 'id' => $employeeFamily->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($employeeFamilies) == 0)
                                        <tr>
                                            <td colspan="5" class="text-left" style="color:red;">No Employee Family
                                                found!
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $employeeFamilies->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- ///////////////////////////////////////////////////////// -->







                    <div role="tabpanel" class="tab-pane" id="tab_employee_internal_experience">
                   
                        <div class=" no-padding no-border">
                            <div class="">

                                @canany(['employee.internal-experience.icrud', 'employee.internal-experience.create'])
                                    <a href="{{ route('{employee}/internal-experience.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in">
                                        <span class="ladda-label"><i class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee Internal Experience' }}</span> </a> 


                                            <a href="#" class="btn  btn-outline-primary mr-1" data-style="zoom-in">
                                                <span class="ladda-label">

                                                    Total Internal Exp: 

                                    <strong>
                                                    {{  $crud->entry->calculateTotalSum()['years'] }} years
                                                    {{  $crud->entry->calculateTotalSum()['months'] }} months
                                                    {{  $crud->entry->calculateTotalSum()['days'] }} days
                                    </strong>

                                                    </span> 
                                                </a> 
        
                                @endcanany

                          
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Job Title</th>
                                        <th> Employmet type </th>
                                        <th>Service year </th>

                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($internalExperiences as $internalExperience)
                                        <tr>
                                            <td>{{ $internalExperience->unit?->name }}</td>
                                            <td>{{ $internalExperience->jobTitle?->name }}</td>
                                            <td>{{ $internalExperience->employmentType->name ?? '-' }}</td>
                                            <td> From {{ $internalExperience->start_date->format('d-m-Y') }} -
                                                {{ $internalExperience->end_date?->format('d-m-Y') ?? 'Now' }} E.C</td>
                                            <td>

                                            <td>



                                                

                                                @canany(['employee.internal-experience.icrud',
                                                    'employee.internal-experience.edit'])
                                                    <a href="{{ route('{employee}/internal-experience.edit', ['employee' => $crud->entry?->id, 'id' => $internalExperience->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany
                                                @canany(['employee.internal-experience.icrud',
                                                    'employee.internal-experience.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/internal-experience.destroy', ['employee' => $crud->entry?->id, 'id' => $internalExperience->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($internalExperiences) == 0)
                                        <tr>
                                            <td colspan="6" class="text-left" style="color:red;">No Internal
                                                Experience
                                                found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $internalExperiences->links() }}
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="tab_employee_external_experience">
                        <h5>Employee External Experience</h5>
                        <div class=" no-padding no-border">
                            <div class="">

                                @canany(['employee.external-experience.icrud', 'employee.external-experience.create'])
                                    <a href="{{ route('{employee}/external-experience.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Employee External Experience' }}</span></a>


                                            <a href="#" class="btn  btn-outline-primary mr-1" data-style="zoom-in">
                                                <span class="ladda-label">

                                                    Total External Exp:
                                                    <strong>
                                                    {{  $crud->entry->calculateExTotalSum()['years'] }} years
                                                    {{  $crud->entry->calculateExTotalSum()['months'] }} months
                                                    {{  $crud->entry->calculateExTotalSum()['days'] }} days
                                                    </strong>

                                                    </span> 
                                                </a> 
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        {{-- <th>Unit</th> --}}
                                        <th>Job Title</th>
                                        <th>Employeemet type </th>
                                        <th>Service Year</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($externalExperiences as $externalExperience)
                                        <tr>
                                            {{-- <td>{{ $externalExperience-> }}</td> --}}
                                            <td>{{ $externalExperience->company_name }}</td>
                                            <td>{{ $externalExperience->job_title_id }} </td>
                                            <td>{{ $externalExperience->employmentType->name ?? '-' }}</td>
                                            <td>From {{ $externalExperience->start_date->format('d-m-Y') }} -
                                                {{ $externalExperience->end_date->format('d-m-Y') }} E.C</td>

                                            <td>


                                                @canany(['employee.external-experience.icrud',
                                                    'employee.external-experience.edit'])
                                                    <a href="{{ route('{employee}/external-experience.edit', ['employee' => $crud->entry?->id, 'id' => $externalExperience->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany
                                                @canany(['employee.external-experience.icrud',
                                                    'employee.external-experience.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/external-experience.destroy', ['employee' => $crud->entry?->id, 'id' => $externalExperience->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($externalExperiences) == 0)
                                        <tr>
                                            <td colspan="7" class="text-left" style="color:red;">No External
                                                Experience
                                                found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $externalExperiences->links() }}
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="tab_training_and_experience">
                        <h5>Training and Studies</h5>
                        <div class=" no-padding no-border">
                            <div class="">

                                @canany(['employee.training-study.icrud', 'employee.training-study.create'])
                                    <a href="{{ route('{employee}/training-and-study.create', ['employee' => $crud->entry?->id]) }}"
                                        class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i
                                                class="la la-plus"></i> {{ trans('backpack::crud.add') }}
                                            {{ 'Training and  Studies' }}</span></a>
                                @endcanany
                            </div>
                            <table id="crudTable"
                                class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Education Level</th>
                                        <th>Country</th>
                                        <th>Institution</th>
                                        <th>City</th>
                                        <th>Leave date</th>
                                        <th>Study End</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trainingAndStudies as $trainingAndStudy)
                                        <tr>
                                            <td>{{ $trainingAndStudy?->name }}</td>
                                            <td>{{ $trainingAndStudy->educationalLevel?->name }}</td>
                                            <td>{{ $trainingAndStudy->nationality->label }}</td>
                                            <td>{{ $trainingAndStudy->inistitution }}</td>
                                            <td>{{ $trainingAndStudy->city }}</td>
                                            <td>{{ $trainingAndStudy->date_of_leave->format('Y M, d') }}</td>
                                            <td>{{ $trainingAndStudy->end_of_study->format('Y M, d') }}</td>
                                            <td>


                                                @canany(['employee.training-study.icrud', 'employee.training-study.edit'])
                                                    <a href="{{ route('{employee}/training-and-study.edit', ['employee' => $crud->entry?->id, 'id' => $trainingAndStudy->id]) }}"
                                                        class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                                                @endcanany
                                                @canany(['employee.training-study.icrud', 'employee.training-study.delete'])
                                                    <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                        data-route="{{ route('{employee}/training-and-study.destroy', ['employee' => $crud->entry?->id, 'id' => $trainingAndStudy->id]) }}"
                                                        class="btn btn-sm btn-link" data-button-type="delete"><i
                                                            class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($trainingAndStudies) == 0)
                                        <tr>
                                            <td colspan="8" class="text-left" style="color:red;">No External
                                                Experience
                                                found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div>
                                {{ $trainingAndStudies->links() }}
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div> <!-- the end of hidden on mobile device -->
@endsection
@canany(['employee.promotion.icrud', 'employee.promotion.index'])
    @include('/employee.promtion')
@endcanany
@canany(['employee.demotion.icrud', 'employee.demotion.index'])
    @include('/employee.demotion')
@endcanany
@canany(['employee.leave.icrud', 'employee.leave.index'])
    @include('/employee.leave')
@endcanany
@canany(['employee.discipline.icrud', 'employee.discipline.index'])
    @include('/employee.misconduct')
@endcanany
@canany(['employee.efficency.icrud', 'employee.efficency.index'])
    @include('/employee.efficiency')
@endcanany
{{-- @canany(['employee.promotion.icrud', 'employee.promotion.index']) --}}
{{-- @include('/employee.attendance') --}}
{{-- @endcanany --}}


@section('after_styles')
    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/crud.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/show.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/backpack/crud/js/crud.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>
    <script src="{{ asset('packages/backpack/crud/js/show.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>

<script>
    $(function() {
        @if (old('code') != null && $errors->has('new') == false)
            $('#position_code_edit').modal('show');
        @endif
    });

    function editEntry(route, value) {
        $('#position_code_edit_form').attr('action', route);
        $('#old_job_code').val(value);
        $('#job_code').val('');
    }

    function deleteEntry(button) {
        var route = $(button).attr('data-route');

        swal({
            title: "{!! trans('backpack::base.warning') !!}",
            text: "{!! trans('backpack::crud.delete_confirm') !!}",
            icon: "warning",
            buttons: ["{!! trans('backpack::crud.cancel') !!}", "{!! trans('backpack::crud.delete') !!}"],
            dangerMode: true,
        }).then((value) => {
            if (value) {
                $.ajax({
                    url: route,
                    type: 'DELETE',
                    success: function(result) {
                        if (result == 1) {
                            // Redraw the table
                            if (typeof crud != 'undefined' && typeof crud.table !=
                                'undefined') {
                                // Move to previous page in case of deleting the only item in the table
                                if (crud.table.rows().count() === 1) {
                                    crud.table.page("previous");
                                }
                                $(button).parent().parent().remove();
                                crud.table.draw(false);
                            }

                            // Show a success notification bubble
                            new Noty({
                                type: "success",
                                text: "{!! '<strong>' . trans('backpack::crud.delete_confirmation_title') . '</strong><br>' . trans('backpack::crud.delete_confirmation_message') !!}"
                            }).show();

                            // Hide the modal, if any
                            $('.modal').modal('hide');
                        } else {
                            // Handle notifications
                            handleNotifications(result);
                        }
                    },
                    error: function(result) {
                        // Show an alert with the result
                        handleNotifications(result);
                    }
                });
            }
        });
    }

    function handleNotifications(result) {
        // If the result is an array, it means we have notification bubbles to show
        if (result instanceof Object) {
            // Trigger one or more bubble notifications
            Object.entries(result).forEach(function(entry, index) {
                var type = entry[0];
                entry[1].forEach(function(message, i) {
                    new Noty({
                        type: type,
                        text: message
                    }).show();
                });
            });
        } else {
            // Show an error alert
            swal({
                title: "{!! trans('backpack::crud.delete_confirmation_not_title') !!}",
                text: "{!! trans('backpack::crud.delete_confirmation_not_message') !!}",
                icon: "error",
                timer: 4000,
                buttons: false,
            });
        }
    }

    // Initialize Select2 Elements
    $(document).ready(function() {
        $('.select2').select2();
    });

    // // make it so that the function above is run after each DataTable draw event
    //  crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');

    function createPopupWin(pageURL, pageTitle, popupWinWidth, popupWinHeight) {
        var left = (screen.width - popupWinWidth) / 2;
        var top = (screen.height - popupWinHeight) / 4;

        var myWindow = window.open(pageURL, pageTitle,
            'resizable=yes, width=' + popupWinWidth +
            ', height=' + popupWinHeight + ', top=' +
            top + ', left=' + left);
    }
</script>



<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>


    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection
