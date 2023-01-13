@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [

    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        
    </section>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card p-2">
            <ul class="col-12 row list-unstyled">
                @foreach ($attributes as $attribute)
                    <li class="col-6 mt-1 "><a href="#" id="att_{{ $attribute->id }}" onclick="addAtrribute('{{ $attribute->name }}', {{ $attribute->id }})" class="choices btn-xs btn btn-secondary block text-sm">{{ $attribute->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    {{-- background-size: cover; background-image: url('img/mopfrontdes.png'); --}}
    <div id="front" class="col-4 mt-3 p1" style="position:fixed; top:0; right:0; height: 278px; width:100%; z-index:1000; background-size: cover; background-image: url('{{ URL::to('/').'/storage/idcard/'.$idCard->front_page }}');">
        {!! $idCard?->front_page_template !!}
        {{-- <h5>Front</h5> --}}
        {{-- <img style="max-width: 100%" width="100%" height="100%" id="preview1" src="{{ URL::to('/').'/storage/idcard/'.$idCard->front_page }}"> --}}
    </div>
    <div id="back" class="col-4 mt-3 p2" style="position:fixed; top:0;right:0; height: 278px; width:100%; z-index:1000; background-size: cover; background-image: url('{{ URL::to('/').'/storage/idcard/'.$idCard->back_page }}');">
        {!! $idCard?->back_page_template !!}
        {{-- <h5>Back</h5>
        <img width="100%" height="100%" id="preview2" src="{{ URL::to('/').'/storage/idcard/'.$idCard->back_page }}"> --}}
    </div>
</div>

<div class="row">
    <div class="col-md-9" style="z-index: 1000">
        <ul class="nav nav-tabs" role="tablist">
            <li id="front_tab" class="nav-item"><a class="nav-link active" data-toggle="tab" href="#front_page" role="tab" aria-controls="front_page" aria-selected="true">Front Page</a></li>
            <li id="back_tab" class="nav-item"><a class="nav-link" data-toggle="tab" href="#back_page" role="tab" aria-controls="back_page" aria-selected="false">Back Page</a></li>
            </ul>
        <form id="save-design" action="{{ route('save.design', ['idcard'=>$idCard->id]) }}" method="post">
            @csrf
            <div class="tab-content">
                <div class="tab-pane active" id="front_page" role="tabpanel">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Front<small> Attributes</small></div>
                        <div class="card-body">
                            <div id="accordion" role="tablist">
                                <div class="row" id="add_tab">
                                    {!! $idCard?->front_page_tab !!}
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="back_page" role="tabpanel">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Front<small> Attributes</small></div>
                        <div class="card-body">
                            <div id="accordion" role="tablist">
                                <div class="row" id="add_tab2">
                                    {!! $idCard?->back_page_tab !!}
                                </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="tab1_temp" id="tab1_temp">
            <input type="hidden" name="tab2_temp" id="tab2_temp">
            <input type="hidden" name="front_data" id="front_data">
            <input type="hidden" name="back_data" id="back_data">
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>
    
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
    <script>
        $(document).ready(function() {
            $('#back').hide();
            $('#front').show();
        });
        $('#front_tab').click(function(){
            $('#back').hide();
            $('#front').show();
        })
        $('#back_tab').click(function(){
            $('#front').hide();
            $('#back').show();
        })

        var check_existence = [];
        function addAtrribute(name, id) {
            var active_tab = $("ul.nav-tabs li a.active")[0].text;
            if (active_tab == 'Front Page') {
                tab_add = '#add_tab';
            } else {
                tab_add = '#add_tab2';
            }
            trim_name = name.replace(' ', '');
            if(jQuery.inArray(id, check_existence) == -1){
                $(tab_add).append(
                '<div class="col-4" id="attribute'+id+'">\
                    <div class="card mb-0">\
                          <div class="card-header" id="heading'+trim_name+'" role="tab">\
                            <h5 class="mb-0"><a data-toggle="collapse" href="#collapse'+trim_name+'" aria-expanded="false" aria-controls="collapse'+trim_name+'" class="collapsed">'+name+'</a> <a href="#" class="float-right" onclick="removedata('+id+')"><i class="fa fa-minus"></i></a></h5>\
                          </div>\
                          <div class="collapse" id="collapse'+trim_name+'" role="tabpanel" aria-labelledby="heading'+trim_name+'" data-parent="#accordion" style="">\
                            <div class="card-body" id="body'+trim_name+'">\
                                <div class="form-group">\
                                    <input class="form-control" id="textVal'+id+'" oninput="changetextVal('+id+')" type="text" placeholder="Enter '+name+'">\
                                    <input class="form-control" id="x'+id+'" oninput="changexVal('+id+')" type="number" placeholder="x value">\
                                    <input class="form-control" id="y'+id+'" oninput="changeyVal('+id+')" type="number" placeholder="y value">\
                                    <input class="form-control" id="size'+id+'" oninput="changeSizeVal('+id+')" type="number" placeholder="size">\
                                    <input class="form-control" id="color'+id+'" oninput="changeColorVal('+id+')" type="color" placeholder="color">\
                                    <a id="bold'+id+'" onClick="changeBold('+id+')" class="btn btn-default btn-sm mr-2 mb-2 mt-2" >\
                                        <i class="fa fa-bold"></i>\
                                    </a>\
                                    <a id="italic'+id+'" onClick="changeItalic('+id+')" class="btn btn-default btn-sm mr-2 mb-2 mt-2" >\
                                        <i class="fa fa-italic"></i>\
                                    </a>\
                                    <a id="underline'+id+'" onClick="changeUnderline('+id+')" class="btn btn-default btn-sm mb-2 mt-2" >\
                                        <i class="fa fa-underline"></i>\
                                    </a>\
                                    <select id="fontFamily'+id+'" onchange="changeFontFamily('+id+')" class="form-control select2">\
                                        <option value="">Choose...</option>\
                                        <option value="Times New Roman" style="font-family: Times New Roman">Times New Roman</option>\
                                        <option value="Lucida Console" style="font-family: Lucida Console">Lucida Console</option>\
                                        <option value="Arial"  style="font-family: Arial">Arial</option>\
                                        <option value="Courier New" style="font-family: Courier New">Courier New</option>\
                                    </select>\
                                </div>\
                            </div>\
                          </div>\
                    </div>\
                </div>\
                '
            );
            
                $("#att_"+id).addClass("disabled");
                check_existence.push(id);
            }  
            
        }

        function removedata(id) {
            $('#attribute'+id).remove();
            $("#att_"+id).removeClass("disabled");
            check_existence = jQuery.grep(check_existence, function(value) {
                return value != id;
            });
        }

        // $("#textVal1").on("input", function() {
        //     alert('asa')
        // })
        
        function changetextVal(id) {
            inputId = 'textVal'+id
            if (!document.getElementById('textVal-'+id)) {
                const para = document.createElement("p");
                para.setAttribute('id','textVal-'+id);
                val = $('#'+inputId).val()
                para.innerText = val;
                para.style.position = "relative"
                document.getElementById('front').appendChild(para);
            } else {
                para = document.getElementById('textVal-'+id)
                val = $('#'+inputId).val()
                para.innerText = val;
                para.style.position = "relative"
                document.getElementById('front').appendChild(para);
            }
            
        }
        function changexVal(id) {
            inputId = 'x'+id
            val = $('#'+inputId).val()
            par = document.getElementById('textVal-'+id)
            par.style.left = val+"px";
        }
        function changeyVal(id) {
            inputId = 'y'+id
            val = $('#'+inputId).val()
            par = document.getElementById('textVal-'+id)
            par.style.top = val+"px";
        }
        function changeSizeVal(id) {
            inputId = 'size'+id
            val = $('#'+inputId).val()
            par = document.getElementById('textVal-'+id)
            par.style.fontSize = val+"px";
        }
        function changeColorVal(id) {
            inputId = 'color'+id
            val = $('#'+inputId).val()
            par = document.getElementById('textVal-'+id)
            par.style.color = val;
        }
        function changeBold(id) {
            inputId = 'bold'+id
            par = document.getElementById('textVal-'+id)
            if (par.style.fontWeight == 'bold') {
                par.style.fontWeight = '';
            } else {
                par.style.fontWeight = 'bold'
            }
        }
        function changeItalic(id) {
            inputId = 'italic'+id
            par = document.getElementById('textVal-'+id)
            if (par.style.fontStyle == 'italic') {
                par.style.fontStyle = '';
            } else {
                par.style.fontStyle = 'italic'
            }
        }
        function changeUnderline(id) {
            inputId = 'underline'+id
            par = document.getElementById('textVal-'+id)
            if (par.style.textDecoration == 'underline') {
                par.style.textDecoration = '';
            } else {
                par.style.textDecoration = 'underline'
            }
        }
        function changeFontFamily(id) {
            inputId = 'fontFamily'+id
            val = $('#'+inputId).val()
            par = document.getElementById('textVal-'+id)
            par.style.fontFamily = val
        }

        $('#save-design').submit(function(e) {
            $('#tab1_temp').val($('#add_tab').html());
            $('#tab2_temp').val($('#add_tab2').html());
            $('#front_data').val($('#front').html());
            $('#back_data').val($('#back').html());
            // var idcardID = "<?php echo $idCard->id; ?>";
            e.preventDefault();
            let formData = new FormData(this);
            $('#file-input-error').text('');
            $.ajax({
                type:'POST',
                url: "{{ route('save.design', ['idcard'=>$idCard->id]) }}",
                data: formData, 
                contentType: false,
                processData: false,
                success: (response) => {
                    console.log(response.data);
                },
                error: function(response){
                    $('#file-input-error').text(response.responseJSON.message);
                }
            });
        })
        
    </script>
@endsection
