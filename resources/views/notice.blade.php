@extends(backpack_view('blank'))

@push('after_styles')
    <style>
        footer {
            display: none !important;
        }
    </style>
@endpush

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="alert alert-default" role="alert" style="color:black;">
                     @auth
                      Welcome,  {{ __('You are logged in') }} as <u> {{ auth()->user()->name }}! </u>
                     @endauth
                    </div>


                </div>

                <div class="card-body">
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <br><br><br><br><br><br>  <br><br><br><br><br><br>
            
                     
                   

               

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
