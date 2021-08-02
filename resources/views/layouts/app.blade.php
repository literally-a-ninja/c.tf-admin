<!DOCTYPE html>
<html lang='en-us'>
<head>
	<meta charset="UTF-16">
	<meta name="viewport" content="width=device-width; height=device-height; maximum-scale=1.4; initial-scale=1.0; user-scalable=yes" />
	<meta name="application-name" content='C.TF Watchroom' />
	<meta name="author" content="John Chandara <email@john.science>">
	<meta name="description" content="Administrative panel for the Creators.TF economy and player management.">
	<meta name="googlebot" content="noarchive,nosnippet" />
	<meta http-equiv='content-type' content='text/html; charset=UTF-16' />
	@production
		<meta http-equiv='content-security-policy'
		      content="script-src 'self' 'unsafe-inline' ajax.cloudflare.com static.cloudflareinsights.com cdnjs.cloudflare.com cdn.jsdelivr.net; report-uri " />
	@endproduction
	
	<title>C.TF Watchroom</title>
	
	{{-- Font Awesome --}}
	<link rel="stylesheet"
	      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
	      integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
	      crossorigin="anonymous"
	      referrerpolicy="no-referrer" />
	
	{{-- Bootstrap4 Toggle --}}
	<link rel="stylesheet"
	      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.css"
	      integrity="sha512-EzrsULyNzUc4xnMaqTrB4EpGvudqpetxG/WNjCpG6ZyyAGxeB6OBF9o246+mwx3l/9Cn838iLIcrxpPHTiygAA=="
	      crossorigin="anonymous"
	      referrerpolicy="no-referrer" />
	
	{{-- AdminLTE --}}
	<link rel="stylesheet"
	      href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
	      integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
	      crossorigin="anonymous"
	      referrerpolicy="no-referrer" />
	
	{{-- iCheck --}}
	<link rel="stylesheet"
	      href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
	      integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
	      crossorigin="anonymous"
	      referrerpolicy="no-referrer" />
	
	{{-- Select2
	<link rel="stylesheet"
	      href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
	      integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
	      crossorigin="anonymous"
	      referrerpolicy="no-referrer" />
	--}}
	
	{{-- Datetime Picker
	<link rel="stylesheet"
	      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css"
	      integrity="sha512-tjNtfoH+ezX5NhKsxuzHc01N4tSBoz15yiML61yoQN/kxWU0ChLIno79qIjqhiuTrQI0h+XPpylj0eZ9pKPQ9g=="
	      crossorigin="anonymous"
	      referrerpolicy="no-referrer" />
	--}}
	
	@once
		<x:sri.link href="css/app.css" rel="stylesheet" />
		@yield('third_party_stylesheets')
	@endonce
	
	@stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
	<!-- Main Header -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
		</ul>

		<ul class="navbar-nav ml-auto">
			<li class="nav-item dropdown user-menu">
				<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
					<img src="https://creators.tf/cdn/assets/images/creators_logo_square.png"
					     class="user-image img-circle elevation-2" alt="User Image">
					<span class="d-none d-md-inline">{{true ? 'C.TF Staff Member' : Auth::user()->name }}</span>
				</a>
				<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<!-- User image -->
					<li class="user-header bg-primary">
						<img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
						     class="img-circle elevation-2"
						     alt="User Image">
						<p>
							{{ true ? 'Potatofactory' : Auth::user()->name }}
							<small>Member since {{ true ? 'May 12th' : Auth::user()->created_at->format('M. Y') }}</small>
						</p>
					</li>
					<!-- Menu Footer-->
					<li class="user-footer">
						<a href="#" class="btn btn-default btn-flat">Profile</a>
						<a href="#" class="btn btn-default btn-flat float-right"
						   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							Sign out
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</li>
				</ul>
			</li>
		</ul>
	</nav>
	
	<!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<div class='content'>
			<header class='content-header flex-column d-flex'>
			  <div class='content-header'>
				@include('partial.feedback-alert')
				  @include('layouts/flash-messages')
			  </div>
				@yield('header')
			</header>
		  <nav>
			  @yield('nav')
		  </nav>
		  <main role='main' class="content">
			  @yield('content')
		  </main>
		</div>
	</div>
	
	<!-- Main Footer -->
	<footer class="main-footer">
		<strong>
			<a
				href='mailto:email@john.science?cc=admin@creators.tf&subject=%5BCSP%20Report%5D%20C.TF%20Watchroom&body=Dear%20Johnny%2C%0A%0AI%20hope%20you%20are%20having%20a%20wonderful%20day%2C%20though%20I%20wanted%20to%20report%20a%20content%20security%20issue.%0A%0A'
			>Report abuse</a>.
		</strong>
		<strong>Copyright &copy; 2021 Creators.TF et al.</strong> All rights reserved.
		<div class="float-right d-none d-sm-b/lock">
			<b>Version</b> alpha-1749:080521
		</div>
	</footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"
        integrity="sha512-++c7zGcm18AhH83pOIETVReg0dr1Yn8XTRw+0bWSIWAVCAwz1s2PwnSj4z/OOyKlwSXc4RLg3nnjR22q0dhEyA=="
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
        integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"
        integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg=="
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"
        integrity="sha512-J+763o/bd3r9iW+gFEqTaeyi+uAphmzkE/zU8FxY6iAvD3nQKXa+ZAWkBI9QS9QkYEKddQoiy0I5GDxKf/ORBA=="
        crossorigin="anonymous"></script>

<script>
	$(function () {
		bsCustomFileInput.init();
	});
	
	$('input[data-bootstrap-switch]').each(function () {
		$(this).bootstrapSwitch('state', $(this).prop('checked'));
	});
</script>

@yield('third_party_scripts')

@stack('page_scripts')
</body>
</html>
