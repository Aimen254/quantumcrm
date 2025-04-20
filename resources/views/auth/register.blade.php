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
                                    <a href="index.html"><img src="{{ asset('images/logo/logo-full.png') }}" alt=""></a>
                                </div>
                                <h4 class="text-center mb-4">Sign up your account</h4>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="mb-1 form-label">Username</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="username">
                                        @error('name')
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle result"></i> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1 form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="hello@example.com">
                                        @error('email')
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle result"></i> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <label class="form-label" for="dz-password">Password</label>
                                        <input type="password" name="password" id="dz-password" class="form-control">
                                        <span class="show-pass eye">
                                            <i class="fa fa-eye-slash"></i>
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        @error('password')
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle result"></i> {{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                        <span class="show-pass eye">
                                            <i class="fa fa-eye-slash"></i>
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="plan_id">Select a Plan</label>
                                        <select name="plan_id" class="form-control">
                                            <option value="">Choose a Plan</option>
                                            @foreach ($plans as $plan)
                                                <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                                    {{ $plan->name }} - ${{ $plan->price }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('plan_id')
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle result"></i> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                    </div>
                                </form>
                                <div class="new-account mt-3">
                                    <p>Already have an account? <a class="text-primary" href="{{ route('login') }}">Sign in</a></p>
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
