@extends(backpack_view('layouts.plain'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <br><br>

            <style>
                #top{

                    border-top : 3px solid  #000FF;
                }

                  </style>
            {{-- <h3 class="text-center mb-4">{{ trans('backpack::base.login') }}</h3> --}}
            <div class="card"  style="border-radius:5%; border-top-color: blue; border-top-width:2px;">

                 <div class="card-header text-center">

                    <span>  <img src="{{ asset('image/logo.jpg') }}" alt="" style="width: 60px; height: 70px;">  </span>
            <small> Human Resource Managment System(2022)

                </small>
                 </div>

                <div class="card-body">
                    <p class="login-box-msg" style=" text-align:center;color:blue;"> <i class ="la la-hand-point-right"> </i> Sign in to start your session </p>
                     <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" for="{{ $username }}"> <i class="la la-user"> </i> &nbsp; {{ config('backpack.base.authentication_column_name') }}</label>

                            <div>
                                <input type="text" placeholder="Enter email " class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}">

                                @if ($errors->has($username))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first($username) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password">  <i class="la la-lock"> </i> &nbsp; {{ trans('backpack::base.password') }}</label>

                            <div>
                                <input type="password"  placeholder="Enter password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

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
                                        <input type="checkbox" name="remember"> {{ trans('backpack::base.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ trans('backpack::base.login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (backpack_users_have_email() && config('backpack.base.setup_password_recovery_routes', true))
                <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
            @endif
            @if (config('backpack.base.registration_open'))
                <div class="text-center"><a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></div>
            @endif
            <br><br>
        </div>
    </div>
@endsection
