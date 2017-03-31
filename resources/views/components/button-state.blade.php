@if($title == 'review')
    <button class="btn btn-info btn-rounded btn-sm" onclick="checkButton('{{ $cpar->date_confirmed }}', '{{ route('review', $cpar->id) }}')" @if($cpar->cparAnswered->status <> 1 || $cpar->cparClosed->status == 1) disabled="disabled" @endif>
        <span class="fa fa-legal"> {{ $slot }}</span>
    </button>
@elseif($title == 'view')
    <button class="btn btn-default btn-rounded btn-sm" onclick="location.href='{{ route('cpars.show', $cpar->id) }}';">
        <span class="fa fa-share"> {{ $slot }}</span>
    </button>
@elseif($title == 'edit')
    <button class="btn btn-default btn-rounded btn-sm" onclick="location.href='{{ route('cpars.edit', $cpar->id) }}';" @if($cpar->cparAnswered->status == 1 || $cpar->cparClosed->status == 1) disabled="disabled" @endif>
        <span class="fa fa-pencil"> {{ $slot }}</span>
    </button>
@elseif($title == 'close')
    <button type="button" class="btn btn-primary btn-rounded btn-sm" onclick="closeCpar()" @if($cpar->cparClosed->status == 1) disabled = "disabled" @endif>
        <span class="fa fa-times"> {{ $slot }}</span>
    </button>
@endif