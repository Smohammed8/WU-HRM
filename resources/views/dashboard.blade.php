@extends(backpack_view('blank'))


@section('content')
    @cannot('dashboard.content')
        <h3 class="text-center">Welcome to {{ env('APP_NAME') }}</h3>
    @endcan
    @can('dashboard.content')

            <!-- /.row -->

<style>

.bg-blue{

    background-color: #0067b8 !important;

}

</style>
<br><br>

     <!-- <div class="card card-primary card-outline"> -->
        
      <div class="card">

        <div class="card-header">
            <h5 class="mb-2"> Real time stastices </h5>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="container-fluid animated fadeIn">


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

               <hr>
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
                                <span class="info-box-number">0</span>
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
                                <span class="info-box-number">0</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
        </div><!-- /.card-body -->
      </div>
<!-- /.container-fluid -->

  <!-- /.content -->



    </div>
    <hr>


            <style>
                .card-header {
                    font-weight: bold;
                }
            </style>


            <div class="row" name="widget_707545443" section="after_content">

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header"> <i class="la la-list"> </i> Employees Statistics</div>
                        <div class="card-body">
                            @foreach ($employeeTypes as $employeeType)
                                {{ $employeeType->name . ' : ' . $employeeType->employees()->count() }}&nbsp;
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header"> <i class="la la-list"> </i> Gender Based Statistics</div>
                        <div class="card-body"> Male Staff : {{ $males }} &nbsp; Female Staff: {{ $females }}
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
            <div class="col-md-6">
            <div class="card card">  <!-- card card-info -->
                <div class="card-header">
                  <h4 class="card-title"><i class="fa fa-users"></i> Employee Classification by Pie Chart</h4>

                  <div class="card-tools">

                  </div>
                </div>
                <div class="card-body">

                    <div id="piechart" style="height: 370px; width: 100%;"></div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>

             <div class="col-md-6">
                <div class="card card">  <!-- card card-info -->
                    <div class="card-header">
                      <h4 class="card-title"><i class="fa fa-users"></i> Employement line graph </h4>

                      <div class="card-tools">

                      </div>
                    </div>
                    <div class="card-body">

                     <div id="#" style="height: 370px; width: 100%;"></div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>

            </div>


            </div>
        </div>

    @endcan

    <?php

    $dataPoints = array(
        array("label"=>"Admin Sytaff", "y"=>90),
        array("label"=>"Academic staff", "y"=>4),
        array("label"=>"Health staff", "y"=>4),
        array("label"=>"Others", "y"=>8),

    )

    ?>
 <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


        <script>

        window.onload = function() {
        var chart = new CanvasJS.Chart("piechart", {
        animationEnabled: true,
        exportEnabled: true,
        // title: {
        //     text: "Jimma University"
        // },
        // subtitles: [{
        //     text: " Employee Classification"
        // }],
        data: [{
            type: "pie",
            //yValueFormatString: "#,##0.00\"%\"",
            yValueFormatString: "#,##0\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
        });
        chart.render();

        }


        </script>

@endsection
