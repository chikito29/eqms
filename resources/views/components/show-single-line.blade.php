<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">{{ $label }}</label>
    <div class="col-md-9 col-xs-12">
        <label class="control-label pull-left">{{ $slot }}</label>

        @if(isset($help))
            <span class="help-block">{{ $help }}</span>
        @endif
    </div>
</div>
