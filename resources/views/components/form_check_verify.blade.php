<div class="col-sm-10 col-sm-offset-1">
	<div class="form-group">
		<div class="row">
			<div class="col-xs-1 col-sm-1 col-md-1" style="margin-right: 0px; padding-right: 0px;">
				<input type="checkbox" name="{{ @$uniqid }}" id="{{ @$uniqid }}_{{ @$i }}" value="Evet">
			</div>
			<div class="col-xs-11 col-sm-11 col-md-11" style="margin-left: 0px; padding-left: 0px;">
				<label for="{{ @$uniqid }}_{{ @$i }}">
					<strong>{!! @$title !!}</strong>
					@if (@$required)
					<small>({{ @$required_text }})</small>
					@endif
					
					@if ( env('APP_ENV') == 'local')
					<small>({{ @$order_no }})</small>
					@endif
				</label>
			</div>

			@if ($errors->has( @$uniqid ))
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div id="{{ @$uniqid }}-error" class="error text-danger pl-3" for="{{ @$uniqid }}" style="display: block;">
					<strong>{{ $errors->first( @$uniqid ) }}</strong>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
