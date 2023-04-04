{{-- @extends('base') --}}
@extends(backpack_view('blank'))




<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet"> <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<link href="{{ asset('treeview.css') }}" rel="stylesheet">




@section('content')




        <div class="card" style="border-radius:0%; border-top-color: #0067b8; border-top-width:2px;">
        <div class="card-header" >


            <div class="panel-heading"><i class="fa fa-university"> </i>  <b>  New Jimma University Structure  </b>          <span class="float-right"><i class="fa fa-download"> </i> <b> <a  href="{{ route('structure-pdf') }}"> Download Structure(PDF)  </a> </b> </span> </div>

   

        </div>
        <div class="card-body" >

            <div class="container" style="font-size:16px;margin-left:0px;">

                <div class="panel panel-info">

                      <div class="panel-body">

                          <div class="row">

                              <div class="col-md-9">

                             
                                

                                    <ul id="tree1" class="tree">


                                    @foreach($orgs as $unit)

                                        <li  class="closed">

                                             @if ($unit->parent_unit_id == null)
                                          <div class="card border-primary mb-3 " style="max-width: 20rem; border-radius:1%; border-top-color: #0067b8; border-top-width:1px;   border-bottom-color: #0067b8; border-bottom-width:1px; border-right-color: #0067b8; border-right-width:1px; border-left-color: #0067b8; border-left-width:3px;">
                                          <div class="card-header">  <i class="fa fa-sitemap"> </i><strong title="Click box to view full stracture"> {{ $unit->name }}   </strong>  </div>
            
            
                                              
                                              </div>


                                              @else
                                              {{ $unit->name }}
                                              @endif 

                                            @if(count($unit->childs))

                                                @include('manageChild',['childs' => $unit->childs ?? ''])

                                            @endif

                                        </li>

                                    @endforeach

                                </ul>

                              </div>


                              <div class="col-md-3">

                               <div class="card" style="margin-right:0px; border-radius:0%; border-left-color: #0067b8; border-left-width:2px;">

                               

                                <img src=" {{ asset('top.png') }}"  style="float:right; " alt="Image" width="550" height="600"/>

                        
                            </div>
                            <small style="text-align:right;">Figure 1.1 Top Jimma University structure    </small>

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

@section('after_scripts')
    <script src="{{ asset('tree.js') }}" type="text/javascript"></script>
@endsection
