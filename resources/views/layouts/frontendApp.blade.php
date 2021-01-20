<!doctype html>
<html lang="en">
<head>
<base href="{{ url('/') }}/" />
<meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="storage/form/assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="storage/form/assets/img/favicon.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>{{ $form['title'] }}</title>

<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<meta name="viewport" content="width=device-width" />

<script src="storage/form/assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>

<!--     Fonts and icons     -->
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">

<!-- CSS Files -->
<link href="storage/form/assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="storage/form/assets/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />

<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="storage/form/assets/css/demo.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" rel="stylesheet" />

<style>
.form-group {
	padding: 5px 7px 0px 7px;
}

div.error {
	margin-bottom:10px;
}
</style>

</head>

<body>
	<div class="image-container set-full-height" style="background-color: rgb(22, 151, 243); background-image: url('storage/form/assets/img/wizard.jpgAAA')">
		<!--   Creative Tim Branding   -->

		<!--   Big container   -->
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<!--      Wizard container        -->
					<div class="wizard-container" style="padding-top: 40px;">
						<div class="card wizard-card" style="min-height: 220px;" data-color="orange" id="wizardProfile">
							<form action="" method="post">
								<div class="wizard-header">
								<div class="row">
									<div class="col-sm-10 col-sm-offset-1">
										<a href="https://nixarsoft.com" target="_blank" style="display: block; text-align: center;">
											<img src="storage/form/assets/img/logo.png" style="height: 100px;">
										</a>
									</div>
								</div>
									<h2 class="text-center" style="margin: 0px 0 10px;">
										<b>{{ $form['title'] }}</b>
									</h2>
								</div>

								@if ( env('APP_ENV') == 'local')
									@if ($errors->any())
										<div class="alert alert-danger">
										<ul>
										@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
										@endforeach
										</ul>
										</div>
									@endif
								@endif

								@yield('content')
							</form>
						</div>
					</div>
					<br />
					<br />
				</div>
			</div>
			<!-- end row -->
		</div>
		<!--  big container -->
	</div>
</body>

<!--   Core JS Files   -->
<script src="storage/form/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="storage/form/assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

<!--  Plugin for the Wizard -->
<script src="storage/form/assets/js/gsdk-bootstrap-wizard.js"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="storage/form/assets/js/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js"></script>

</html>
