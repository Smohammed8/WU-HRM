@extends(backpack_view('blank'))


@section('content')
    @cannot('dashboard.content')
        <h3 class="text-center">Welcome to {{ env('APP_NAME') }}</h3>
    @endcan
    @can('dashboard.content')

            <!-- /.row -->
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

.bg-blue{

    background-color: #0067b8 !important;

}
.vertical-separator {
    border-left: 1px solid #ccc; /* Add a vertical line with the desired color and thickness */
    height: 100%; /* Match the height of the columns */
    margin-left: 10px; /* Adjust the margin as needed to control the spacing between the charts and the separator */
    margin-right: 10px;
}
</style>
<br><br>

     <!-- <div class="card card-primary card-outline"> -->
        
      <div class="card">
        <div class="card-header">
            <h5 class="mb-2"> <i class="fa fa-list"></i> System Analytics </h5>

            @canany('employee-sample.export')
            <a href="{{ route('employee-form') }}" class="btn  btn-sm btn-outline-primary float-right mr-1"> <i class="fa fa-download"></i> Export</a>
        
            @endcanany
            @canany('employee.import')
            <button type="button" class="btn  btn-sm btn-outline-primary float-right mr-1" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-upload"></i>  Import
            </button>
            @endcanany
       
            @canany('download.manual')
            <a href="{{ route('user-manual') }}" class="btn  btn-sm btn-outline-primary float-right mr-1"> <i class="fa fa-book"></i> Download User Manual</a>
            @endcanany

        </div> <!-- /.card-body -->

        <div class="container-fluid" style="padding: 0;">
        <div class="row">
        <div class="col-md-9">
         
                 <div class="card card d-none d-md-block">
                    <div class="card-header">
                      <h4 class="card-title">
                        <i class="fa fa-users"></i> Employee Classification by Pie Chart</h4>
    
                      <div class="card-tools">
    
                      </div>
                    </div>
                    <div class="card-body">
    
                        {{-- <div id="piechart" style="height: 370px; width: 100%;"></div> --}}

                        <div id="chartContainer1"  style="height: 370px; width: 100%;"></div>
                       
                    </div>
<hr>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div id="chartContainer2" style="height: 300px; width: 100%;"></div>
                                </div>
                                <div class="col-md-1 vertical-separator"></div>
                                <div class="col-md-5">
                                    <div id="chartContainer3" style="height: 300px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- /.card-body -->
                  </div>
                    
        </div>
        
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"> <a href="{{ route('employee.index', []) }}" title="Click to view details">  <i class="fa fa-users"></i></a></span>

                 <div class="info-box-content">
                     <span class="info-box-text">Employees</span>
                     <span class="info-box-number">{{ number_format($employees, 0, '.', ',') }}
                    
                      , M:{{ $males }}, F:{{ $females }}
                     </span>
                 </div>
                 <!-- /.info-box-content -->
             </div>

             <div class="info-box">
                <span class="info-box-icon bg-success"> <a href="{{ route('employee.checkRetirment', []) }}" title="Click to view details"> <i class="fa fa-user-minus"></i> </a> </span>

                <div class="info-box-content">
                    <span class="info-box-text">Retirements </span>
                    <span class="info-box-number">{{ $retired }} </span>
                </div>
                <!-- /.info-box-content -->
            </div>

            <div class="info-box">
                <span class="info-box-icon bg-warning"> <a href="{{ route('employee.checkLeave') }}" title="Click to view details"> <i class="fa fa-user-plus"></i> </a></span>

                <div class="info-box-content">
                    <span class="info-box-text"> Emloyee Leaves</span>
                    <span class="info-box-number">{{ $active_leaves}} </span>
                </div>
                <!-- /.info-box-content -->
            </div>


            <div class="info-box">
                <span class="info-box-icon bg-danger"> <a href="#" title="Click to view details"> <i class="fa fa-users"></i> </a> </span>

                <div class="info-box-content">
                    <span class="info-box-text"> Total Permanet</span>
                    <span class="info-box-number">{{ $permanets }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box"> <!--    <div class="info-box shadow"> -->
                <span class="info-box-icon bg-info"> <a href="{{ route('unit.index', []) }}" title="Click to view details">  <i class="fa fa-sitemap"></i> </a> </span>

                <div class="info-box-content">
                    <span class="info-box-text">Organizational units</span>
                    <span class="info-box-number">{{ $units }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>

            <div class="info-box">
                <span class="info-box-icon bg-success"> <a href="{{ route('employee.probation', []) }}" title="Click to view details"> <i class="fa fa-user-tie"></i> </a> </span>

                <div class="info-box-content">
                    <span class="info-box-text">In probation Period  </span>
                    <span class="info-box-number">{{  $probations }} </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box">
                <span class="info-box-icon bg-warning"><a href="{{ route('position.index', []) }}" title="Click to view details">  <i class="fa fa-list"></i> </a> </span>

                <div class="info-box-content">                                <span class="info-box-text">Vacant positions </span>
                    <span class="info-box-number"> {{ $freepositions }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

            <div class="info-box">
                <span class="info-box-icon bg-danger"> <a href="#" title="Click to view details">  <i class="fa fa-users"></i> </a></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Non-permanents </span>
                    <span class="info-box-number">{{ $non_permanets }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->


        </div>
    </div>
</div>

      

      <div class="card card-body">
        <div class="row">
            @canany(['HR-all.manage'])

            @if (backpack_user()->hr_branch_id == null)

            @foreach($offices  as $hr)
            <div class="col-md-3">   
                <div class="card card-defualt">  
                    <!-- card card-info -->
                    <span class="border border-secondary">
                    <div class="card-header">
                      <h4 class="card-title"><i class="fa fa-flag"></i>   <a href=""> 
                        {{ $hr->name }}
                         {{-- Main HR Office  --}}
                         </a> 
                        </h4>
                    </div>  
                 

                    <div class="col-md-12 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-default"> 
                                <a href="{{ route('getEmployee', ['hr_branch_id'=>$hr->id]) }}

                                " title="Click to view details"> 
                                     <i class="fa fa-sitemap"></i>
                                </a>
                              </span>
                              <div class="info-box-content">
                                <span class="info-box-text">Total Employees</span>
                                <span class="info-box-number">{{  $hr->employees->count() }} </span>
                            
                             </div>
                        </div>
                    </div>

              
                        
              

                   </span>
                  </div>
                  <!-- /.card -->
                </div>
                @endforeach

                @else

                @foreach($offices  as $hr)

                @if (backpack_user()->hr_branch_id == $hr->id)

                <div class="col-md-3">   
                    <div class="card card-defualt">  
                        <!-- card card-info -->
                        <span class="border border-secondary">
                        <div class="card-header">
                          <h4 class="card-title"><i class="fa fa-flag"></i>   <a href=""> 
                            {{ $hr->name }}
                             {{-- Main HR Office  --}}
                             </a> 
                            </h4>
                        </div>  
                    
                        <div class="col-md-12 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-default"> 
                                    <a href="{{ route('getEmployee', ['hr_branch_id'=>$hr->id]) }}
    
                                    " title="Click to view details"> 
                                         <i class="fa fa-sitemap"></i>
                                    </a>
                                  </span>
                                  <div class="info-box-content">
                                    <span class="info-box-text">Total Employees</span>
                                    <span class="info-box-number">{{  $hr->employees->count() }} </span>
                                
                                 </div>
                            </div>
                        </div>
    
                       </span>
                      </div>
                      <!-- /.card -->
                    </div>
                    @endif
                    @endforeach 
                @endif

                @endcanany
             </div>   
          </div>
        </div>
    </div>
    </div>
    <hr>
  


            <style>
                .card-header {
                    font-weight: bold;
                }
              
            .info-box:hover {
                background-color: #0067b8;
                color:white;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            }
            </style>
            <hr>
@endcan
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Batch importing Employee data </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('import-employee') }}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="email1"> CSV File</label>
                <input type="file" class="form-control" id="file" name="file" aria-describedby="file" placeholder="Upload file">
                <small id="file" class="form-text text-muted">Your information is safe with us.</small>
              </div>
            
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          <button type="submit" class="btn btn-primary">Import</button>
        </div>

    </form>
      </div>
    </div>
  </div>



    <?php

    // $dataPoints = array(
    //     array("label"=>"Administrative staff", "y"=>99),
    //     array("label"=>"Academics 	 staff", "y"=>0.3),
    //     array("label"=>"Health staff", "y"=>0.3),
    //     array("label"=>"Research", "y"=>0.4),


    // )

    ?>
 <script src="{{ asset('assets/js/canvasjs.min.js') }}"></script>
 {{-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> --}}
 <script type="text/javascript">
     // Chart 1
     var chart1 = new CanvasJS.Chart("chartContainer1", {
        exportEnabled: true,
        animationEnabled: true,  
	title:{
		text: "Employee performance index per"
	},
    subtitles: [{
		text: "Consecutive Fiscal Year",
		fontSize: 16
	}],

	axisY: {
		title: "Obtained marks",
		valueFormatString: "#0,,.",
		suffix: "%",
		stripLines: [{
			value: 3366500,
			label: "Average"
		}]
	},
	data: [{
		yValueFormatString: "#,### Units",
		xValueFormatString: "YYYY",
		type: "spline",
		dataPoints: [
			{x: new Date(2002, 0), y: 2506000},
			{x: new Date(2003, 0), y: 2798000},

			{x: new Date(2004, 0), y: 3386000},
			{x: new Date(2005, 0), y: 6944000},

			{x: new Date(2006, 0), y: 6026000},
			{x: new Date(2007, 0), y: 2394000},

			{x: new Date(2008, 0), y: 1872000},
			{x: new Date(2009, 0), y: 2140000},

			{x: new Date(2010, 0), y: 7289000},
			{x: new Date(2011, 0), y: 4830000},

			{x: new Date(2012, 0), y: 2009000},
			{x: new Date(2013, 0), y: 2840000},

			{x: new Date(2014, 0), y: 2396000},
			{x: new Date(2015, 0), y: 1613000},

			{x: new Date(2016, 0), y: 2821000},
			{x: new Date(2017, 0), y: 2000000}
		]
	}]
});
 
     // Chart 2
     var chart2 = new CanvasJS.Chart("chartContainer2", {
    theme: "light2",  // "light1", "light2", "dark1", "dark2"
    exportEnabled: true,
	animationEnabled: true,
	title: {
		text: "Employee Classification by"
	},
	subtitles: [{
		text: "by Category",
		fontSize: 16
	}],
	data: [{
		type: "pie",
		indexLabelFontSize: 13,
		radius: 90,
		indexLabel: "{label} - {y}",
		yValueFormatString: "###0.0\"%\"",
		click: explodePie,
		dataPoints: [
			{ y: 42, label: "Academic Staff" },
			{ y: 21, label: "Adminstrative staff"},
			{ y: 24.5, label: "Health Staff" },
			{ y: 9, label: "Technical Staff" },
			{ y: 3.1, label: "Other Staff" }
		],
      
        
	}]
});

var chart3 = new CanvasJS.Chart("chartContainer3", {
        theme: "light2",
        exportEnabled: true,
	animationEnabled: true,
	title: {
		text: "Employee Performance"
	},
	subtitles: [{
		text: "Measeurement",
		fontSize: 16
	}],
	data: [{
		type: "pie",
		indexLabelFontSize: 13,
		radius: 90,
		indexLabel: "{label} - {y}",
		yValueFormatString: "###0.0\"%\"",
		click: explodePie,
		dataPoints: [
			{ y: 42, label: "95-100" },
			{ y: 21, label: "90-94"},
			{ y: 24.5, label: "80-89" },
			{ y: 9, label: "70-79" },
			{ y: 3.1, label: "Less than 70" }
		]
	}]
});
 
     // Render the charts
     chart1.render();
     chart2.render();
     chart3.render();

     function explodePie(e) {
	for(var i = 0; i < e.dataSeries.dataPoints.length; i++) {
		if(i !== e.dataPointIndex)
			e.dataSeries.dataPoints[i].exploded = false;
	}
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}
     
 </script>
 
    

@endsection
