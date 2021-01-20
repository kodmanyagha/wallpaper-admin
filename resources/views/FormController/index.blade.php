@extends('layouts.frontendApp', ['activePage' => 'dashboard', 'titlePage' => $titlePage]) @section('content')

<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="form-group">
			<hr style="width: 100%" />
		</div>
	</div>
	
	@foreach( $form['form_elements'] as $element )
		@include('components.' . $element['type'], $element)
	@endforeach
	
	<div class="col-sm-10 col-sm-offset-1">
		<br />
		<div class="form-group">
			<button type="submit" class="btn  btn-fill btn-primary btn-wd btn-sm btn-block">
				<i class="fas fa-envelope"></i>
				&nbsp; 
				@if ( strlen( $form['send_button_text'] ) > 0 )
					{{ $form['send_button_text'] }}
				@else
					Gönder
				@endif
			</button>
		</div>
	</div>
</div>

@endsection @push('js') @endpush
