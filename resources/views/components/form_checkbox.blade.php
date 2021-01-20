<div class="col-sm-10 col-sm-offset-1">
    <div class="form-group">
        <label>
            <strong>{{ @$title }}</strong>
            @if (@$required)
                <small>({{ @$required_text }})</small>
            @endif

            @if ( env('APP_ENV') == 'local')
                <small>({{ @$order_no }})</small>
            @endif

        </label>
        <br/>

        @foreach( $properties['options'] as $i => $prop )
            <input type="checkbox" name="{{ @$uniqid }}[]" id="{{ @$uniqid }}_{{ @$i }}" value="{{ @$prop }}">
            <label for="{{ @$uniqid }}_{{ @$i }}">{{ @$prop }}</label>

            <br/>
        @endforeach

        @if ( strlen( @$description ) > 0 )
            <small class="form-text text-muted">{{ @$description }}</small>
        @endif

        @if ($errors->has( @$uniqid ))
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div id="{{ @$uniqid }}-error" class="error text-danger pl-3" for="{{ @$uniqid }}"
                         style="display: block;">
                        <strong>{{ $errors->first( @$uniqid ) }}</strong>
                    </div>
                </div>
            </div>
        @endif
        <script>
            $(function () {
                $('input:checkbox[name={{ @$uniqid }}]').val(['{{ old(@$uniqid, '') }}'])
            });
        </script>

    </div>
</div>
