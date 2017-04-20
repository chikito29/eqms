@if($title == 'review')
    <button id="review-btn" class="btn btn-info btn-rounded btn-sm @if($cpar->cparClosed->status == 1) hidden @endif" onclick="checkButton('{{ $cpar->date_confirmed }}', '{{ route('cpars.review', $cpar->id) }}')">
        <span class="fa fa-legal"> {{ $slot }}</span>
    </button>
@elseif($title == 'view')
    <button class="btn btn-default btn-rounded btn-sm" onclick="location.href='{{ route('cpars.show', $cpar->id) }}';">
        <span class="fa fa-share"> {{ $slot }}</span>
    </button>
@elseif($title == 'edit')
    <button id="edit-btn" class="btn btn-default btn-rounded btn-sm @if($cpar->cparReviewed->on_review == 1 || $cpar->cparClosed->status == 1 || $cpar->cparAnswered->status == 1) hidden @endif" onclick="location.href='{{ route('cpars.edit', $cpar->id) }}';">
        <span class="fa fa-pencil"> {{ $slot }}</span>
    </button>
@elseif($title == 'close')
    <button id="close-btn" type="button" class="btn btn-primary btn-rounded btn-sm @if($cpar->cparClosed->status == 1 || $cpar->cparReviewed->on_review == 1 || $cpar->cparAnswered->status == 1) hidden @endif" onclick="closeCpar({{  $cpar->id }})">
        <span class="fa fa-times"> {{ $slot }}</span>
    </button>
@elseif($title == 'Create CPAR Number')
    <button id="create-cpar-number-btn" class="btn btn-info btn-rounded btn-sm @if((\App\HelperClasses\User::isAdmin(request('user.id')) || \App\HelperClasses\User::isDocumentController(request('user.id'))) && $cpar->cparReviewed->status == 1) @else hidden @endif" onclick="openCparNumberModal({{ $cpar->id }})">
        <span class="fa fa-plus"> {{ $slot }}</span>
    </button>
@elseif($title == 'Print Reviewed CPAR')
    <button id="print-reviewed-cpar-btn" class="btn btn-info btn-rounded btn-sm @if(\App\HelperClasses\User::isAdmin(request('user.id')) || \App\HelperClasses\User::isDocumentController(request('user.id'))) @else hidden @endif" onclick='window.open("{{ route('action-summary', $cpar->id) }}")'>
        <span class="fa fa-print"> {{ $slot }}</span>
    </button>
@elseif($title == 'Print Closed CPAR')
    <button id="print-closed-cpar-btn" class="btn btn-info btn-rounded btn-sm
    @if(request('user.type') <> 'admin' || ($cpar->cparClosed->status <> 1 && $cpar->cparReviewed->status <> 1))
            hidden
    @endif"
        onclick='window.location.href = "{{ route('action-summary', $cpar->id) }}"'>
        <span class="fa fa-print"> {{ $slot }}</span>
    </button>
@endif
