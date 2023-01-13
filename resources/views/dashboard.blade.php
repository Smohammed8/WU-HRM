@extends(backpack_view('blank'))


@section('content')
    @cannot('dashboard.content')
        <h3 class="text-center">Welcome to {{ env('APP_NAME') }}</h3>
    @endcan
    @can('dashboard.content')
        <div class="container-fluid animated fadeIn">

            <h5 class="mb-2"> Real time stastices </h5>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                       <span class="info-box-icon bg-info"> <a href="{{ route('employee.index', []) }}" title="Click to view details">  <i class="fa fa-users"></i></a></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Employees</span>
                            <span class="info-box-number">{{ number_format($employees, 0, '.', ',') }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-user-minus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Reay for retirments</span>
                            <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-user-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"> On Leave</span>
                            <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fa fa-user-minus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Resignations</span>
                            <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- =========================================================== -->
            <h5 class="mb-2">Info Box With Custom Shadows <small><i>Using Bootstrap's Shadow Utility</i></small></h5>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-none">
                        <span class="info-box-icon bg-info"><i class="fa fa-sitemap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Organizational units</span>
                            <span class="info-box-number">{{ $units }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-success"><i class="fa fa-user-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Trail periods </span>
                            <span class="info-box-number">8</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-warning"><i class="fa fa-flag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Free Job positions </span>
                            <span class="info-box-number"> {{ $positions }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-danger"><i class="fa fa-star"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">New promotions</span>
                            <span class="info-box-number">13</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->










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
