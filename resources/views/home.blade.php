@extends('layout.frontend')

@push('style')
<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"/>
<style>
.card-hover {
    transition: all 0.3s ease-in-out;
    transform: scale(1);
}
.card-hover:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
}
.bg-gradient {
    background: linear-gradient(135deg, #007bff, #6610f2);
}
</style>
@endpush

@section('content')
<!-- Full-width Header with Navigation -->
<header class="bg-primary text-white py-4 shadow">
    <div class="container-fluid px-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0 text-white">Quanta CRM</h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="#home" class="nav-link text-white">Home</a></li>
                    <li class="nav-item"><a href="#pricing" class="nav-link text-white">Register</a></li>
                    <li class="nav-item"><a href="{{route('login')}}" class="nav-link text-white">Login</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section id="home" class="py-5" style="background: linear-gradient(135deg, #e0f7fa, #f1f8e9);">
    <div class="container-fluid px-5">
        <div class="row align-items-center">
            <div class="col-md-6 animate__animated animate__fadeInLeft">
                <h2 class="mb-3">Empower Your Growth with a Personal CRM<span class="text-primary"> Quanta CRM</span></h2>
                <p class="mb-4">A sleek, one-page platform where users can explore plans, register, and seamlessly manage their own CRM dashboard — built for freelancers, creators, and small businesses.</p>
                <a href="#pricing" class="btn btn-primary shadow">See Pricing</a>
            </div>
            <div class="col-md-6 text-center animate__animated animate__fadeInRight">
                <img src="{{ asset('assets/images/landing.jpg') }}" alt="Profile" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!-- Pricing Section -->
<section id="pricing" class="py-5 bg-white">
    <div class="container-fluid px-5 text-center">
        <h2 class="mb-5 fw-bold">Our Plans</h2>
        <div class="row justify-content-center g-4">
            @foreach ($plans as $index => $plan)
                <div class="col-md-4 wow animate__animated animate__fadeInUp" data-wow-delay="{{ 0.2 + ($index * 0.2) }}s">
                    <div class="card shadow-lg border{{ $plan->name === 'Pro' ? ' border-primary' : '-0' }} h-100 card-hover rounded-4 p-3 position-relative overflow-hidden">
                        @if($plan->name === 'Pro')
                            <div class="position-absolute top-0 end-0 px-3 py-1 bg-gradient text-white small fw-bold rounded-bottom-start">Most Popular</div>
                        @endif
                        <div class="card-body">
                            <h5 class="text-uppercase {{ $plan->name === 'Pro' ? 'text-primary' : 'text-muted' }} fw-bold">{{ $plan->name }}</h5>
                            <h2 class="text-primary display-5 fw-bold">${{ $plan->price }}<span class="fs-6">/mo</span></h2>
                            <hr>
                            <ul class="list-unstyled my-4 text-start small">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $plan->name === 'Pro' ? '10 Projects' : '1 Project' }}</li>
                                <li class="mb-2"><i class="bi {{ $plan->name === 'Pro' ? 'bi-lightning-charge-fill' : 'bi-envelope-fill' }} text-success me-2"></i>{{ $plan->name === 'Pro' ? 'Priority Support' : 'Email Support' }}</li>
                                <li class="mb-2"><i class="bi {{ $plan->name === 'Pro' ? 'bi-stars' : 'bi-sliders2' }} text-success me-2"></i>{{ $plan->name === 'Pro' ? 'Advanced Features' : 'Basic Features' }}</li>
                            </ul>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="btn {{ $plan->name === 'Pro' ? 'btn-primary' : 'btn-outline-primary' }} w-100">Choose Plan</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <div class="container-fluid">
        &copy; {{ date('Y') }} MyBio. All rights reserved.
    </div>
</footer>
@endsection

@push('script')
<!-- WOW.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    new WOW().init();
</script>
@endpush
