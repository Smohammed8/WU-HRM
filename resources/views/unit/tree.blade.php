{{-- @extends('base') --}}
@extends(backpack_view('blank'))


<link rel="stylesheet" type="text/css" href="{{ asset('tree.css') }}" /> 


<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet"> <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<link href="{{ asset('treeview.css') }}" rel="stylesheet">




@section('content')
  



        <div class="card" style="border-radius:0%; border-top-color: #0067b8; border-top-width:2px;">
        <div class="card-header" >
            
      
            <div class="panel-heading"><i class="fa fa-sitemap"> </i> <b>Jimma University Structure </b> </div>
            
        </div>
        <div class="card-body" >

            <div class="container" style="font-size:16px;">     

                <div class="panel panel-info">
            
                      <div class="panel-body">
            
                          <div class="row">
            
                              <div class="col-md-12">
            
            
                                    <ul id="tree1" class="tree">
                                        
            
                                    @foreach($orgs as $unit)
            
                                        <li  class="closed">
                                            
                                          <i class="fa fa-flag"> </i>
                                            {{ $unit->name }}
            
                                            @if(count($unit->childs))
                                       
                                                @include('manageChild',['childs' => $unit->childs ?? ''])
                                            
                                            @endif
            
                                        </li>
            
                                    @endforeach
            
                                </ul>
            
                              </div>
            
                        
             {{-- <div class="col-md-6">
                  /////////////// form
        
                              
            
                          </div> --}}
            
            
                          
            
                      </div>
            
                </div>
            
            </div>
        


        </div>
      </div>

   


    
      
@endsection

<script>

    $(function() {
        $('#tree1 ul').hide(400).parent().prepend('');
        $('#tree1').on('click', 'li', function(e) {
            e.stopPropagation();
            $(this).children('ul').slideToggle(400);
        
         
        });
    });
    

    </script>

<script src="{{ asset('treeview.js') }}"></script>

{{-- @section('after_scripts')
    <script src="{{ asset('tree.js') }}" type="text/javascript"></script>
@endsection --}}
