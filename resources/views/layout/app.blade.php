<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from yashadmin.dexignzone.com/xhtml/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Apr 2025 04:33:55 GMT -->
<head>
	<!--Title-->
	<title>Quantum CRM -is a cloud-based Customer Relationship Management platform </title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords"
		content="Quantum CRM, is a cloud-based Customer Relationship Management platform tailored for small
			to medium-sized enterprises (SMEs) seeking to unify customer data, automate sales workflows,
			and mitigate compliance risks. ">

	<meta name="description"
		content=" QuantaCRM is a cloud-based Customer Relationship Management platform tailored for small
		to medium-sized enterprises (SMEs) seeking to unify customer data, automate sales workflows,
		and mitigate compliance risks. ">

	<meta property="og:title"
		content="Quantum CRM | Our Team">
	<meta property="og:description"
		content=" QuantaCRM is a cloud-based Customer Relationship Management platform tailored for small
			to medium-sized enterprises (SMEs) seeking to unify customer data, automate sales workflows,
			and mitigate compliance risks. ">
	<meta property="og:image" content="social-image.png">

	<meta name="format-detection" content="telephone=no">

	<meta name="twitter:title"
		content="Quantum CRM | Our Team">
	<meta name="twitter:description"
		content=" QuantaCRM is a cloud-based Customer Relationship Management platform tailored for small
			to medium-sized enterprises (SMEs) seeking to unify customer data, automate sales workflows,
			and mitigate compliance risks. ">
	<meta name="twitter:image" content="social-image.png">
	<meta name="twitter:card" content="summary_large_image">

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/favicon.png')}}">
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    @include('layout.styles')
    @stack('style')
</head>
<body>
<div id="preloader">
    <div>
        <img src="{{ asset('assets/images/loader.png')}}" alt="">
    </div>
</div>
<div id="main-wrapper">
    @include('layout.header')
    @include('layout.sidebar')
    <div class="content-body">
        <div class="container-fluid">
        @yield('content')
        </div>
    </div>
    @include('layout.footer')
	@include('modal.delete-modal')
</div>
@include('layout.script')
@stack('script')
</body>
</html>