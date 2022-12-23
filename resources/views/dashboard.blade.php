@extends(backpack_view('blank'))


@section('content')
    @cannot('dashboard.content')
        <h3 class="text-center">Welcome to {{ env('APP_NAME') }}</h3>
    @endcan
    @can('dashboard.content')
        <div class="container-fluid animated fadeIn">
            <div name="widget_81117463" section="before_content" class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 text-white bg-primary">
                        <div class="card-body">
                            <div class="text-value">{{ number_format($employees, 0, '.', ',') }}</div>

                            <div> Total Employees</div>

                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <small class="text-muted"><a href="{{ route('employee.index', []) }}" style="color:white;"> </a><i
                                    class=" la la-download"></i> View more </a></small>
                        </div>

                    </div>
                </div>

                <!-- /////////////////////////////////////////////////// -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 text-white bg-success">
                        <div class="card-body">
                            <div class="text-value">0</div>

                            <div> Ready for penssion</div>

                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="80"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <small class="text-muted"><a href="" style="color:white;"> <i class=" la la-download"></i>
                                    View more </a></small>
                        </div>

                    </div>
                </div>

                <!-- /////////////////////////////////////////////////// -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 text-white bg-warning">
                        <div class="card-body">
                            <div class="text-value"> 0</div>
                            <div> On annual leave</div>
                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="30"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted"><a href="" style="color:white;"> <i class=" la la-download"></i>
                                    View more </a></small>
                        </div>
                    </div>
                </div>

                <!-- /////////////////////////////////////////////////// -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 text-white bg-danger">
                        <div class="card-body">
                            <div class="text-value"> 0</div>
                            <div> Resignation </div>
                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="30"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted"><a href="" style="color:white;"> <i class=" la la-download"></i>
                                    View more </a></small>
                        </div>
                    </div>
                </div>

                <!-- /////////////////////////////////////////////////// -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 text-white bg-dark">
                        <div class="card-body">
                            <div class="text-value">{{ $units }}</div>
                            <div> Organizational units .</div>
                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <small class="text-muted"><a href="" style="color:white;"> <i class=" la la-download"></i>
                                    View more </a></small>
                        </div>

                    </div>
                </div>
                <!-- /////////////////////////////////////////////////// -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 text-white bg-info">
                        <div class="card-body">
                            <div class="text-value">0</div>
                            <div> Trail periods </div>
                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <small class="text-muted"><a href="" style="color:white;"> <i class=" la la-download"></i>
                                    View more </a></small>
                        </div>

                    </div>
                </div>
                <!-- /////////////////////////////////////////////////// -->
                <div class="col-sm-6 col-lg-3">

                    <div class="card border-0 text-white bg-pink">
                        <div class="card-body">
                            <div class="text-value">{{ $positions }}</div>
                            <div> Job positions </div>
                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <small class="text-muted"><a href="" style="color:white;"> <i
                                        class=" la la-download"></i> View more </a></small>
                        </div>

                    </div>
                </div>
                <!-- /////////////////////////////////////////////////// -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 text-white bg-green">
                        <div class="card-body">
                            <div class="text-value">0</div>
                            <div>New promotions</div>
                            <div class="progress progress-white progress-xs my-2">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <small class="text-muted"><a href="" style="color:white;"> <i
                                        class=" la la-download"></i> View more </a></small>
                        </div>

                    </div>
                </div>
                <!-- ////////////////// the end of cards ///////////////////////// -->



            </div>

            <style>
                .card-header {
                    font-weight: bold;
                }
            </style>


            <div class="row" name="widget_707545443" section="after_content">

                <div class="col-sm-6">
                    <div class="card" style="border-radius:2%; border-top-color: blue; border-top-width:2px;">
                        <div class="card-header"> <i class="la la-list"> </i> Employees Statistics</div>
                        <div class="card-body">
                            @foreach ($employeeTypes as $employeeType)
                                {{ $employeeType->name . ' : ' . $employeeType->employees()->count() }}&nbsp;
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="card" style="border-radius:2%; border-top-color: blue; border-top-width:2px;">
                        <div class="card-header"> <i class="la la-list"> </i> Gender Based Statistics</div>
                        <div class="card-body"> Male Staff : {{ $males }} &nbsp; Female Staff: {{ $females }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
