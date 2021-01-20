<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<base href="{{ url('/') }}/" />

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ __('Yönetim Paneli') }}</title>
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
<link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.png">
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
	integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
<!-- CSS Files -->
<link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />
<link href="{{ asset('material') }}/css/custom.css" rel="stylesheet" />

<link href="{{ asset('material') }}/flag-icon-css/css/flag-icon.min.css" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('material') }}/plugins/datetimepicker/jquery.datetimepicker.css">

<link href="css/app.css" rel="stylesheet" />

</head>
<body class="{{ $class ?? '' }}">
	@auth()
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
		@include('layouts.page_templates.auth')
	@endauth

	@guest()
		@include('layouts.page_templates.guest')
	@endguest

	<!--   Core JS Files   -->
	<script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="{{ asset('material') }}/js/core/popper.min.js"></script>
	<script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
	<script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
	<!-- Plugin for the momentJs  -->
	<script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
	<!--  Plugin for Sweet Alert -->
	<script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
	<!-- Forms Validations Plugin -->
	<script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
	<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
	<script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
	<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
	<script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
	<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
	<script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
	<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
	<script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
	<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
	<script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
	<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
	<script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
	<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
	<script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
	<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
	<script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
	<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
	<script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
	<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	<!-- Library for adding dinamically elements -->
	<script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
	<!--  Google Maps Plugin    -->
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFnMchkqrijdOSLrgTlIBII_dYG4mLT1Y" async defer></script>
	<!-- Chartist JS -->
	<script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
	<!--  Notifications Plugin    -->
	<script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
	<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
	<script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

	<link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />
	<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="{{ asset('material') }}/js/custom.js"></script>
	<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
	<script src='{{ asset('material') }}/plugins/datetimepicker/jquery.datetimepicker.js'></script>

	<style>
	.mce-notification-inner,
	.mce-notification,  .mce-notification-warning
	{display:none!important;}
	</style>

	@stack('js')

	<script>
	function menuActive() {
		let menuLinks = $(".sidebar-wrapper a.nav-link");
		//console.log(menuLinks);

		let currentUrl = window.location.href;
		let pathName = window.location.pathname;
		let baseUrl = window.location.origin;

		for (let i = 0; i < menuLinks.length; i++) {
			let menuItem = $(menuLinks[i]);
			//console.log(baseUrl + "/" + menuItem.attr('href') + ' ' + currentUrl);

			//if ( baseUrl + "/" + menuItem.attr('href') == currentUrl ) {
			if (('/' + menuItem.attr('href')) == pathName) {
				menuItem.parent().addClass('active');
			}
			//console.log(menuItem);
		}

		let activeItem = $(".sidebar-wrapper").find('li.active');

		activeItem.closest('div.collapse').addClass('show');
		activeItem.closest('div.collapse').parent().addClass('active');
		activeItem.closest('li.nav-item').addClass('active');
	}

	//setTimeout( function() { menuActive(); }, 111 );
	$(document).ready(function() {
		menuActive();

		$('.file-selector-container-b64').each(function( index ) {
			var $this = $( this );
			$this.css('cursor','pointer');
			var $file = $this.find('input[type=file]');
			var $img = $this.find('img');
			var $hidden = $this.find('input[type=hidden]');

			$file.on('change', function() {
				var fileTag = $file[0];

				if (fileTag.files && fileTag.files[0]) {
					var FR = new FileReader();

					FR.addEventListener("load", function(e) {
						$img.attr('src', e.target.result);
						$hidden.val(e.target.result);
					});

					FR.readAsDataURL( fileTag.files[0] );
				}
			});
		});
	});

	$('.select2').select2({ theme: "classic" });
	$('#selSite').on('select2:select', function(e) {
		console.log(e.params.data);

		$.get( "home/changeSite?id=" + e.params.data.id, function( data ) {
			setTimeout(function() {
				location.reload(true);
			}, 111);
		});
	});
	</script>
</body>
</html>
