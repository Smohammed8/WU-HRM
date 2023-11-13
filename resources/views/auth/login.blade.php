@extends(backpack_view('layouts.plain'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            {{-- <form action="{{ route('login.auth') }}" method="POST"> --}}
            @csrf
            <br><br>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <style>
                #top {

                    border-top: 3px solid #000FF;
                }

      
            </style>
            {{-- <h3 class="text-center mb-4">{{ trans('backpack::base.login') }}</h3> --}}
            <div class="card" style="border-radius:5%; border-top-color: #0067b8; border-top-width:2px;">

                <div class="card-header text-center">

                    <span> <img src="{{ asset(\App\Constants::LOGO_PATH) }}" alt="" style="width: 100px; ">
                        <br>
                    </span>
                    <strong style=" text-align:center;color:#0067b8;"> {{ \App\Constants::ORG_LONG }} </strong> <br>
                    <small><strong style=" text-align:center;color:#0067b8;">Human Resource Managment System(HRM) </strong>

                    </small>
                </div>
          


                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                 @endif

                    {{-- Username: admin   and Password: 1213/06 --}}

                <div class="card-body">
                    {{-- <p class="login-box-msg" style=" text-align:center;color:#0067b8;"> <i class="la la-hand-point-right">
                        </i>
                        Sign in to start your session </p> --}}
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" for="{{ $username }}"> <i class="la la-user"> </i> &nbsp;
                                {{ config('backpack.base.authentication_column_name') }}</label>
                            <div>
                                <input type="text" placeholder="Enter username "
                                    class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}"
                                    name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}">

                                @if ($errors->has($username))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first($username) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password"> <i class="la la-lock"> </i> &nbsp;
                                {{ trans('backpack::base.password') }}</label>
                            <div>
                                <input type="password" placeholder="Enter password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                    id="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">
                                        {{ trans('backpack::base.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit"  style="background-color:#0067b8;" class="btn btn-block btn-primary">
                                    {{ trans('backpack::base.login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



{{-- <div class="container mt-5">

    <div class="progress">
        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>

<script>
    function checkLoginProgress() {
        axios.get('/login')
            .then(function (response) {
                const progress = response.data.progress;
                $('#progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
                if (progress < 100) {
                    setTimeout(checkLoginProgress, 1000); // Check progress again after 1 second
                } else {
                    window.location.href = '/notice'; // Redirect to the dashboard when authenticated
                }
            })
            .catch(function (error) {
                console.error(error);
            });
    }

    $(document).ready(function () {
        checkLoginProgress(); // Start checking progress when the document is ready
    }); --}}
</script>

            <br><br>
            {{-- </form> --}}
        </div>
    </div>
@endsection
