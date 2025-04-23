<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quantum CRM</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">

	<meta name="keywords"
		content="YashAdmin, sales Admin Dashboard, Bootstrap Template, Web Application, sales Management, Responsive Design, User Experience, Customizable, Modern UI, Dashboard Template, Admin Panel, Bootstrap 5, HTML5, CSS3, JavaScript, Analytics, Products, Admin Template, UI Kit, SASS, SCSS, CRM, Analytics, Responsive Dashboard, responsive admin dashboard, sales dashboard, ui kit, web app, Admin Dashboard, Template, Admin, CMS pages, Authentication, FrontEnd Integration, Web Application UI, Bootstrap Framework, User Interface Kit, Financial Dashboard, SASS Integration, Customizable Template, Product Management, HTML5/CSS3, CRM Dashboard, Analytics Dashboard, Admin Dashboard UI, Mobile-Friendly Design, UI Components, Dashboard Widgets, Dashboard Framework, Data Visualization, User Experience (UX), Dashboard Widgets, Real-time Analytics, Cross-Browser Compatibility, Interactive Charts, Product Processing, Performance Optimization, Multi-Purpose Template, Efficient Admin Tools, Task Management, Modern Web Technologies, Product Tracking, Responsive Tables, Dashboard Widgets, Invoice Management, Access Control, Modular Design, Product History, Trend Analysis, User-Friendly Interface">

	<meta name="description"
		content="The Yash Admin Sales Management System is a robust and intuitive platform designed to streamline sales operations and enhance business productivity. This comprehensive admin dashboard offers a feature-rich environment tailored specifically for managing sales processes effectively.With its modern and responsive design, Yash Admin provides a seamless user experience across various devices and screen sizes. The user interface is highly customizable, allowing administrators to tailor the dashboard to their specific needs and branding requirements.">

	<meta property="og:title"
		content="YashAdmin -Sales Management System Admin Dashboard Bootstrap HTML Template | DexignZone">
	<meta property="og:description"
		content="The Yash Admin Sales Management System is a robust and intuitive platform designed to streamline sales operations and enhance business productivity. This comprehensive admin dashboard offers a feature-rich environment tailored specifically for managing sales processes effectively.With its modern and responsive design, Yash Admin provides a seamless user experience across various devices and screen sizes. The user interface is highly customizable, allowing administrators to tailor the dashboard to their specific needs and branding requirements.">
	<meta property="og:image" content="social-image.png">

	<meta name="format-detection" content="telephone=no">

	<meta name="twitter:title"
		content="YashAdmin -Sales Management System Admin Dashboard Bootstrap HTML Template| DexignZone">
	<meta name="twitter:description"
		content="The Yash Admin Sales Management System is a robust and intuitive platform designed to streamline sales operations and enhance business productivity. This comprehensive admin dashboard offers a feature-rich environment tailored specifically for managing sales processes effectively.With its modern and responsive design, Yash Admin provides a seamless user experience across various devices and screen sizes. The user interface is highly customizable, allowing administrators to tailor the dashboard to their specific needs and branding requirements.">
	<meta name="twitter:image" content="social-image.png">
	<meta name="twitter:card" content="summary_large_image">

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layout.styles') 
    @stack('style')
</head>

<body>
<div id="preloader">
    <div>
        <img src="{{ asset('assets/images/loader.gif')}}" alt="">
    </div>
</div>
<div id="main-wrapper">
        @yield('content')
       
</div>
@include('layout.script') 
    @stack('script')
</body>
