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
           
          
            @if(Auth::user()->hasRole('super-admin'))
            @canany('export_database')
            <form method="get" action="{{ route('export.database') }}">
                @csrf
                <button class="btn  btn-sm btn-outline-primary float-right mr-1" type="submit"><i class="fa fa-database"></i> ED </button>
            </form>
            @endcanany
            @endif


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

           
        </div> 
        <div class="container-fluid" style="padding: 0;">
        <div class="row">
        <div class="col-md-9">
         
                 <div class="card card d-none d-md-block">
                 
                    <div class="card-body">
    
                        {{-- <div id="piechart" style="height: 370px; width: 100%;"></div> --}}

                        <div id="chartContainer5"  style="height: 300px; width: 100%;"></div>
                       
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

                   <hr>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="chartContainer1" style="height: 370px; width: 100%;">

                                    </div>
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

        
            <div class="card">
                <div class="card-body">
                 
                        <div class="col-md-12">
                          
                            <div id="chartContainer4" style="height: 300px; width: 100%;"></div>
                        </div>
                  
                </div>
            </div>
            <hr>

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
        var employeeData = @json($employeeData); // Convert PHP array to JavaScript object
        var totalItemCount = {{ $totalEmployeeCount }};
        var dataPoints = [];
        @foreach($employeeData as $data)
            dataPoints.push({ x: {{ $data['year'] }}, y: {{ $data['value'] }} });
        @endforeach
        var chart1 = new CanvasJS.Chart("chartContainer1", {
        theme: "light2",  // "light1", "light2", "dark1", "dark2"
        exportEnabled: true,
        animationEnabled: true,
            // Your other chart settings
     title: {
        text: "Yearly average employees performace index for Every 6 months (Ethiopian Calendar)",
        fontSize: 16 // Set the desired font size for the main title
	    },

        
    axisY: {
            title: "Obtained point by percentage",
            suffix: "%",
            viewportMinimum: 0, // Set the minimum y-value to 0%
            viewportMaximum: 100, // Set the maximum y-value to 100%
            interval: 10
    },
                data: [{
                    type: "spline",
                    yValueFormatString: "##.#",
                    dataPoints: dataPoints
                }]
            });
        chart1.render();

 
     var employeeTypes = @json($percentage);
  
     var chart2 = new CanvasJS.Chart("chartContainer2", {
    theme: "light2",  // "light1", "light2", "dark1", "dark2"
    exportEnabled: true,
	animationEnabled: true,
	title: {
		text: "Employee Classification by by Category",
        fontSize: 16 // Set the desired font size for the main title
	},
	// subtitles: [{
	// 	text: "by Category",
	// 	fontSize: 16
	// }],
    data: [{
        type: "pie",
        indexLabelFontSize: 14,
        radius: 90,
       // yValueFormatString: "###0.0\"%",
        click: explodePie,
      showInLegend: true,
        dataPoints:employeeTypes.map(item => ({
            y: item.value,
           
            indexLabel: item.category + " - " + item.percentage.toFixed(2) + "%",
            legendText: item.category
        }))
    }]


});

chart2.render();


 var colleges = @json($bycollege);
var chart3 = new CanvasJS.Chart("chartContainer3", {
        theme: "light2",
        exportEnabled: true,
    	animationEnabled: true,
	    title: {
		text: "Number of Employees by HR Branch",
        fontSize: 16 // Set the desired font size for the main title
	    },
	// subtitles: [{
	// 	text: "College or Institute",
	// 	fontSize: 16
	// }],



    data: [{
        type: "pie",
        indexLabelFontSize: 14,
        radius: 90,
       // yValueFormatString: "###0.0\"%",
        click: explodePie,
        showInLegend: true,
        dataPoints:colleges.map(item => ({
            y: item.value,
           
            indexLabel: item.college + " - " + item.bycollege.toFixed(1) + "%",
            legendText: item.college
        }))
    }]

});
 
chart3.render();

var educationalLevelsData = @json($educationalLevels);
var chart4 = new CanvasJS.Chart("chartContainer4", {
    theme: "light2", //dark2
    exportEnabled: true,
    exportFileName: "Doughnut Chart",
	animationEnabled: true,
	title:{
		text: "Classification by Educational level",
        fontSize: 14, // Set the desired font size for the main title
        horizontalAlign: "left"
	},
	legend:{
		cursor: "pointer",
		itemclick: explodePie
	},
	data: [{
		type: "doughnut",
        radius: 80,
		innerRadius: 50,
        indexLabelFontSize: 12,
		showInLegend: false,
		toolTipContent: "<b>{name}</b>: {y}",
		indexLabel: "{name} -{y}",
        dataPoints: educationalLevelsData.map(function (level) {
            return { y: level.employees_count, name: level.name };
        })
	}]
});

chart4.render();
var hrBranchesData = @json($hrBranches);
var chart5 = new CanvasJS.Chart("chartContainer5", {
    exportFileName: "Column graph",
    exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Gender Classification by College/Institue",
        fontSize: 14, 
        horizontalAlign: "left"
	},
	axisY: {
		title: "Number of Male by College",
		titleFontColor: "#4F81BC",
        fontSize: 12,
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2: {
		title: "Number of Female by College",
        fontSize: 12,
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},	
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Male",
		legendText: "Male",
		showInLegend: true, 
		// dataPoints:[
		// 	{ label: "Main Campus", y: 266.21 },
		// 	{ label: "Health Institute", y: 302.25 },
		// 	{ label: "Natural Science", y: 157.20 },
		// 	{ label: "Social Science", y: 148.77 },
		// 	{ label: "Law & Governance", y: 101.50 },
		// 	{ label: "Business & Economics", y: 97.8 },
        //     { label: "Public Health", y: 17.8 },
        //     { label: "Technology Institue", y: 27.8 },
        //     { label: "Agri & veternary Medecine", y: 30.8 },
        //     { label: "Agaro Campus", y: 213.8 }
            
		// ]

        dataPoints: hrBranchesData.map(function (branch) {
                return { label: branch.name, y: branch.male_count };
            })
	},
	{
		type: "column",	
		name: "Female",
		legendText: "Female",
		axisYType: "secondary",
		showInLegend: true,

        dataPoints: hrBranchesData.map(function (branch) {
                return { label: branch.name, y: branch.female_count };
            })

		// dataPoints:[
		// 	{ label: "Main campus", y: 10.46 },
		// 	{ label: "Health Institute", y: 2.27 },
		// 	{ label: "Natural Science", y: 3.99 },
		// 	{ label: "Social Science", y: 4.45 },
		// 	{ label: "Law & Governance", y: 2.92 },
		// 	{ label: "Business & Economics", y: 3.1 },
        //     { label: "Public Health", y: 7.8 },
        //     { label: "Technology Institue", y: 29.8 },
        //     { label: "Agri & veternary Medecine", y: 10.8 },
        //     { label: "Agaro Campus", y: 13.8 }

		// ]
	}]
});
chart5.render();

     
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
