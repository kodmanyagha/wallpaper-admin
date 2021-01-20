<div class="col-sm-10 col-sm-offset-1">
	<div class="form-group text-center">

		@if (strlen(@$title) > 0)
		<h3>
			<strong>{{ @$title }}</strong>
			@if ( env('APP_ENV') == 'local')
			<small>({{ @$order_no }})</small>
			@endif
		</h3>
		@endif
		
		@if (strlen(@$description) > 0)
		<p>{!! @$description !!}</p>
		@endif
		
	</div>
</div>
