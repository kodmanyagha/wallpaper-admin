@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => $titlePage])

@section('content')
<div class="content">
	<form method="post" enctype="multipart/form-data" action="" autocomplete="off" class="form-horizontal">
		@csrf
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="card ">
						<div class="card-header card-header-primary">
							<h4 class="card-title">{{ $titlePage }}</h4>
						</div>
						<div class="card-body ">
							@if (session('status'))
							<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="material-icons">close</i>
										</button>
										<span>{{ session('status') }}</span>
									</div>
								</div>
							</div>
							@endif
							<div class="row">
								<label class="col-sm-2 col-form-label">{{ __('Kod') }}</label>
								<div class="col-sm-7">
									<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
										<input disabled class="form-control" name="code" id="code"
											type="text" placeholder="{{ __('Kod') }}" value=""/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<button type="submit" class="btn btn-success btn-block btn-lg">
						<i class="fas fa-save"></i>&nbsp;&nbsp;{{ __('Kaydet') }}
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
	  tinymce.init({
		    selector: 'textarea.content-editor',
		    //skin: 'bootstrap',
		    plugins: 'lists, link, image, media',
		    toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
		    menubar: false,
		    height : "480"
		  });
});
</script>


@endpush
