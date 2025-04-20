@extends('layout.auth')
@section('content')
<div class="authincation fix-wrapper">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center mb-3">
                                    <a href="index.html"><img src="images/logo/logo-full.png" alt=""></a>
                                </div>
                                <h4 class="text-center mb-4">Sign up your account</h4>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="mb-1 form-label">Email</label>
                                        <input type="text" class="form-control" name="email" placeholder="Email">
                                        @error('email')
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle result"></i> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 position-relative">
                                        <label class="form-label" for="dz-password">Password</label>
                                        <input type="password" id="dz-password" name="password" class="form-control" value="123456">
                                        <span class="show-pass eye">
                                            <i class="fa fa-eye-slash"></i>
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        @error('password')
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle result"></i> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-row d-flex flex-wrap justify-content-between mb-2">
                                        <div class="form-group mb-sm-4 mb-1">
                                            <div class="form-check custom-checkbox ms-1">
                                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                                <label class="form-check-label" for="basic_checkbox_1">Remember my preference</label>
                                            </div>
                                        </div>
                                        <div class="form-group ms-2">
                                            <a class="text-hover" href="{{ route('password.request') }}">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                    </div>
                                </form>
                                <div class="new-account mt-3">
                                    <p>Already have an account? <a class="text-primary" href="{{ route('register') }}">Sign Up</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection