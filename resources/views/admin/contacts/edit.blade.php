@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-xl-3 col-lg-4">
        <div class="clearfix">
            <div class="card card-bx profile-card author-profile m-b30">
                <div class="card-body">
                    <div class="p-5">
                        <div class="author-profile">
                            <div class="author-media">
                                <img id="profilePreview"
                                    src="{{ $user->photo && file_exists(public_path('storage/' . $user->photo)) 
                                        ? asset('storage/' . $user->photo) 
                                        : asset('assets/images/user.jpg') }}"
                                    alt="" class="rounded-circle">
                                <div class="upload-link" title="" data-toggle="tooltip" data-placement="right" data-original-title="update">
                                    <input type="file" class="d-none" id="externalProfileImageInput" accept="image/*">
                                    <i class="fa fa-camera" id="cameraIcon"></i>
                                </div>
                            </div>
                            <div class="author-info">
                                <span>{{ $user->getRoleNames()->first() ?? 'No role' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-8">
        <div class="card profile-card card-bx m-b30">
            <div class="card-header">
                <h6 class="title">Edit Contact</h6>
            </div>
            <form action="{{ route('contacts.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="profile-form">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <input type="file" name="photo" class="d-none" id="formProfileImageInput">
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->contact->first_name) }}" required>
                            @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->contact->last_name) }}" required>
                            @error('last_name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Specialty</label>
                            <input type="text" class="form-control" name="specialty" value="{{ old('specialty', $user->contact->specialty) }}">
                            @error('specialty')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Gender</label>
                            <select class="default-select form-control" name="gender">
                                <option value="">Please select</option>
                                <option value="Male" {{ old('gender', $user->contact->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $user->contact->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $user->contact->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Birth</label>
                            <div class="input-hasicon mb-xl-0 mb-3">
                                <input class="form-control bt-datepicker" type="date" name="birth" value="{{ old('birth', $user->contact->birth) }}">
                                <div class="icon"><i class="far fa-calendar"></i></div>
                            </div>
                            @error('birth')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label d-block">Phone <span class="text-danger">*</span></label>
                            <input type="tel" id="phone" class="form-control" name="phone" value="{{ old('phone', $user->contact->phone) }}">
                            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        @php
                        $selectedCountry = old('country_id', $user->contact->country);
                        $selectedCity = old('city_id', $user->contact->city);
                        $cities = $countries->firstWhere('id', $selectedCountry)?->cities ?? collect();
                        @endphp

                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Country</label>
                            <select class="default-select form-control" name="country_id" id="countrySelect">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ $selectedCountry == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('country_id')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-sm-6 m-b30">
                            <label class="form-label">City</label>
                            <select class="default-select form-control" name="city_id" id="citySelect">
                                <option value="">Please select</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $selectedCity == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('city_id')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Update Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
<style>
    .iti.iti--allow-dropdown.iti--separate-dial-code {
        width: 100% !important;
    }
</style>
@endpush

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Profile Image Preview + Sync with Form File Input
    const cameraIcon = document.getElementById('cameraIcon');
    const externalInput = document.getElementById('externalProfileImageInput');
    const formInput = document.getElementById('formProfileImageInput');
    const imagePreview = document.getElementById('profilePreview');

    cameraIcon.addEventListener('click', function () {
        externalInput.click();
    });

    externalInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            formInput.files = dataTransfer.files;
        }
    });

    // Country-City Dynamic Dropdown
    const countrySelect = document.getElementById('countrySelect');
    const citySelect = document.getElementById('citySelect');

    const countryCityMap = @json($countries->mapWithKeys(function($country) {
        return [$country->id => $country->cities->mapWithKeys(fn($city) => [$city->id => $city->name])];
    }));

    countrySelect.addEventListener('change', function () {
        const countryId = this.value;
        const cities = countryCityMap[countryId] || {};

        citySelect.innerHTML = '<option value="">Please select</option>';
        Object.entries(cities).forEach(([id, name]) => {
            const option = document.createElement('option');
            option.value = id;
            option.textContent = name;
            citySelect.appendChild(option);
        });
    });

    // Phone input formatting
    const phoneInput = document.querySelector("#phone");
    if (phoneInput) {
        window.intlTelInput(phoneInput, {
            initialCountry: "pk",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });
    }
});
</script>
@endpush
