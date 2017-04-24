<div class="alert alert-{{ session()->pull('attention.color') }}{{ $color }}" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    {!! session()->pull('attention.body') !!}{!! $body !!}
</div>
