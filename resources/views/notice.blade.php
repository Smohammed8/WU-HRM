
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
                <style>

.slide-in-horizontal {
    animation: slideInHorizontal 2s; /* You can adjust the animation duration as needed */
}

@keyframes slideInHorizontal {
    from {
        transform: translateX(-100%);
    }
    to {
        transform: translateX(0);
    }
}
</style>

                <div class="card-body">
                    {{-- <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <br><br><br><br><br><br>  <br><br><br><br><br><br>
             --}}
                     
                    <img src="{{ asset('hrm2.jpg') }}"  width="100%" class="slide-in-horizontal" alt="Example Image">

               

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
