<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">{{ $label }}</label>
    <div class="col-md-9 col-xs-12">
        <div class="panel-body" style="background-color: rgb(249,249,249); padding: 20px; border-radius: 5px;">
            {{ $slot }}
        </div>

        @if(isset($help))
            <span class="help-block">{{ $help }}</span>
        @endif
    </div>
</div>