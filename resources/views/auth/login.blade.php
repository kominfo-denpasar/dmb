<x-laravel-ui-adminlte::adminlte-layout>

    <body class="hold-transition login-page" style="background: #fff;">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/logo_dmb.png') }}">
                </a>
            </div>
            <!-- /.login-logo -->

            <!-- /.login-box-body -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Input email dan password Anda</p>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="post" action="{{ url('/login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @if ($errors->has('h-captcha-response'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        {{ $errors->first('h-captcha-response') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12 text-center">
                                {!! HCaptcha::display() !!}
                                <div>
                                    <button type="submit" class="btn btn-danger btn-block">Login</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            

                        </div>
                    </form>

                    <!-- <p class="mb-1">
                        <a href="{{ route('password.request') }}">Lupa password</a>
                    </p>
                    <p class="mb-0">
                        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                    </p> -->
                    <p class="my-2">
                        Pemerintah Kota Denpasar &copy; 2025
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>

        </div>
        <!-- /.login-box -->
        {!! HCaptcha::renderJs('id') !!}
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
