@extends('layout.app')
@section('content')

<div class="row">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="col-xl-8 col-xxl-8">
        <div class="card h-auto">
            <h4 class="card-intro-title py-3 px-4">Setting</h4>
            <div class="card-body">
                <div class="profile-tab">
                    <div class="custom-tab-1">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">Setting</a>
                            </li>
                            <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link">About Me</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="about-me" class="tab-pane fad">
                                <div class="profile-about-me">
                                    <div class="pt-4 border-bottom-1 pb-3">
                                        <h4 class="text-primary">About Me</h4>
                                        <p class="mb-2">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence was created for the bliss of souls like mine.I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents.</p>
                                        <p>A collection of textile samples lay spread out on the table - Samsa was a travelling salesman - and above it there hung a picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame.</p>
                                    </div>
                                </div>
                                <div class="profile-personal-info">
                                <h4 class="text-primary mb-4">Personal Information</h4>

                                <div class="row mb-2">
                                    <div class="col-sm-3 col-5">
                                        <h5 class="f-w-500">Name <span class="pull-end">:</span></h5>
                                    </div>
                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->name }}</span></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-3 col-5">
                                        <h5 class="f-w-500">Email <span class="pull-end">:</span></h5>
                                    </div>
                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->email }}</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-3 col-5">
                                        <h5 class="f-w-500">Contacts Count <span class="pull-end">:</span></h5>
                                    </div>
                                    <div class="col-sm-9 col-7"><span>{{ Auth::user()->contact()->count() }}</span></div>
                                </div>
                            </div>

                            </div>
                            <div id="profile-settings" class="tab-pane fade active show">
                                <div class="pt-3">
                                    <div class="settings-form">
                                        <h4 class="text-primary">Account Setting</h4>
                                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="author-profile">
                                                <div class="author-media">
                                                    @php
                                                        $user = auth()->user();
                                                        $photoPath = $user->photo && file_exists(public_path('storage/' . $user->photo))
                                                            ? asset('storage/' . $user->photo)
                                                            : asset('assets/images/user.jpg');
                                                    @endphp

                                                    <img id="profilePreview"
                                                        src="{{ $photoPath }}"
                                                        alt="User Photo"
                                                        class="rounded-circle">

                                                    <div class="upload-link" title="" data-toggle="tooltip" data-placement="right" data-original-title="Update">
                                                        <input type="file" class="d-none" id="externalProfileImageInput" name="photo" accept="image/*" onchange="previewImage(event)">
                                                        <i class="fa fa-camera cursor-pointer" id="cameraIcon" onclick="document.getElementById('externalProfileImageInput').click();"></i>
                                                    </div>

                                                    @error('photo')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-xxl-4">
        <div class="card h-auto">
            <h4 class="card-intro-title py-3 px-4">Change Password</h4>
            <div class="card-body">
                <form action="{{ route('profile.password.update') }}" method="POST" id="changePasswordForm">
                    @csrf
                    @method('PUT')

                    {{-- Current Password --}}
                    <div class="mb-3 position-relative">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror" required>
                        <span class="show-pass eye" onclick="togglePassword('current_password', this)">
                            <i class="fa fa-eye-slash"></i>
                            <i class="fa fa-eye d-none"></i>
                        </span>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="mb-3 position-relative">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" id="new_password"
                            class="form-control @error('new_password') is-invalid @enderror" required>
                        <div class="form-text text-muted">
                            Password must be at least 8 characters, contain one capital letter, and one special character.
                        </div>
                        <span class="show-pass eye" onclick="togglePassword('new_password', this)">
                            <i class="fa fa-eye-slash"></i>
                            <i class="fa fa-eye d-none"></i>
                        </span>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-3 position-relative">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="form-control" required>
                        <span class="show-pass eye" onclick="togglePassword('new_password_confirmation', this)">
                            <i class="fa fa-eye-slash"></i>
                            <i class="fa fa-eye d-none"></i>
                        </span>
                    </div>

                    <button type="submit" id="updatePasswordBtn" class="btn btn-primary" disabled>Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
<style>
.show-pass.eye {
    position: absolute;
    top: 38px;
    right: 15px;
    cursor: pointer;
    z-index: 2;
}
.show-pass.eye i {
    margin-left: -8px;
}
.show-pass.eye i.fa-eye.d-none,
.show-pass.eye i.fa-eye-slash.d-none {
    display: none;
}
</style>
@endpush
@push('script')
<script>
     function togglePassword(fieldId, toggleIcon) {
        const field = document.getElementById(fieldId);
        const [eyeSlash, eye] = toggleIcon.querySelectorAll('i');

        if (field.type === "password") {
            field.type = "text";
            eyeSlash.classList.add('d-none');
            eye.classList.remove('d-none');
        } else {
            field.type = "password";
            eye.classList.add('d-none');
            eyeSlash.classList.remove('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const current = document.getElementById('current_password');
        const newPass = document.getElementById('new_password');
        const confirmPass = document.getElementById('new_password_confirmation');
        const submitBtn = document.getElementById('updatePasswordBtn');

        const feedbackContainer = document.createElement('div');
        feedbackContainer.classList.add('text-danger', 'small', 'mt-1');
        newPass.parentNode.appendChild(feedbackContainer);

        function validatePassword() {
            const password = newPass.value;
            const confirm = confirmPass.value;
            let message = '';

            const lengthCheck = password.length >= 8;
            const upperCheck = /[A-Z]/.test(password);
            const specialCheck = /[^A-Za-z0-9]/.test(password);
            const matchCheck = password === confirm;
            const allFilled = current.value && password && confirm;

            if (!lengthCheck) message = 'Password must be at least 8 characters.';
            else if (!upperCheck) message = 'Password must contain at least one uppercase letter.';
            else if (!specialCheck) message = 'Password must contain at least one special character.';
            else if (!matchCheck) message = 'Passwords do not match.';
            else message = '';

            feedbackContainer.textContent = message;
            submitBtn.disabled = !(lengthCheck && upperCheck && specialCheck && matchCheck && allFilled);
        }

        [current, newPass, confirmPass].forEach(input => {
            input.addEventListener('input', validatePassword);
        });
    });
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('profilePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
