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
                            @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->contact->last_name) }}" required>
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Gender<span class="text-danger">*</span></label>
                            <select class="default-select form-control" name="gender" required>
                                <option value="">Please select</option>
                                <option value="Male" {{ old('gender', $user->contact->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $user->contact->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $user->contact->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Birth<span class="text-danger">*</span></label>
                            <div class="input-hasicon mb-xl-0 mb-3">
                                <input class="form-control bt-datepicker" type="date" name="birth" value="{{ old('birth', $user->contact->birth) }}" required>
                                <div class="icon"><i class="far fa-calendar"></i></div>
                            </div>
                            @error('birth')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label d-block">Phone <span class="text-danger">*</span></label>
                            <input type="tel" id="phone" class="form-control" name="phone" value="{{ old('phone', $user->contact->phone) }}" required>
                            <small id="phoneError" class="text-danger d-none">Please enter a valid Pakistani phone number.</small>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @php
                        $selectedCountry = old('country_id', $user->contact->country);
                        $selectedCity = old('city_id', $user->contact->city);
                        $cities = $countries->firstWhere('id', $selectedCountry)?->cities ?? collect();
                        @endphp

                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Country<span class="text-danger">*</span></label>
                            <select class="default-select form-control" name="country_id" id="countrySelect" required>
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ $selectedCountry == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 m-b30">
                            <label class="form-label">City<span class="text-danger">*</span></label>
                            <select class="default-select form-control" name="city_id" id="citySelect" required>
                                <option value="">Please select</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $selectedCity == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
@php
// Fix the country-city map structure
$countryCityMap = [];
foreach ($countries as $country) {
    $countryCityMap[$country->id] = $country->cities->mapWithKeys(function($city) {
        return [$city->id => $city->name];
    })->all();
}
@endphp

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
    const countryCityMap = @json($countryCityMap);
    const countrySelect = document.getElementById('countrySelect');
    const citySelect = document.getElementById('citySelect');
    const oldCityId = "{{ old('city_id', $user->contact->city_id) }}";
    if (!countrySelect || !citySelect) {
        console.error('Required select elements not found!');
        return;
    }
    function loadCities(countryId) {
        console.log('Loading cities for country:', countryId);
        console.log('Available cities data:', countryCityMap[countryId]);
        
        citySelect.innerHTML = '<option value="">Please select</option>';
        
        if (countryId && countryCityMap[countryId]) {
            console.log('Cities found:', countryCityMap[countryId]);
            const cities = countryCityMap[countryId];
            for (const [id, name] of Object.entries(cities)) {
                console.log('Adding city:', id, name);
                const option = new Option(name, id);
                option.selected = (oldCityId == id);
                citySelect.add(option);
            }
        } else {
            console.log('No cities found for country ID:', countryId);
        }
    }
    // Load cities for initial country
    if (countrySelect.value) {
        onsole.log('Cities for this country:', countryCityMap[countrySelect.value]);
        loadCities(countrySelect.value);
    }

    countrySelect.addEventListener('change', function() {
        console.log('Country changed to:', this.value);
        loadCities(this.value);
    });
    const phoneInput = document.querySelector("#phone");
const phoneError = document.querySelector("#phoneError");
let iti;

if (phoneInput) {
    iti = window.intlTelInput(phoneInput, {
        initialCountry: "pk",
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

    phoneInput.addEventListener('input', function () {
        if (iti.isValidNumber() && iti.getSelectedCountryData().iso2 === "pk") {
            phoneError.classList.add('d-none');
        } else {
            phoneError.classList.remove('d-none');
        }
    });

    // Optional: Validate again on form submit
    document.querySelector('.profile-form').addEventListener('submit', function (e) {
        if (!iti.isValidNumber() || iti.getSelectedCountryData().iso2 !== "pk") {
            phoneError.classList.remove('d-none');
            e.preventDefault(); // prevent submission
        }
    });
}
});
</script>
@endpush
