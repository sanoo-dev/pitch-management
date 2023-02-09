@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('admin.index') }}"><b>Quản Lý Sân Bóng Đá</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Đăng nhập vào trang điều khiển</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"" value=" {{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                    <span class="text-red text-sm">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('passowrd')
                    <span class="text-red text-sm">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                Nhớ đăng nhập
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            @if (Route::has('password.request'))
            <p class="mb-1 mt-2 text-center">
                <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            </p>
            @endif
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
@endsection
