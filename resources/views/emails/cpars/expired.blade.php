@component('mail::message')

    # CPAR expired

    The CPAR that has been issued to {{ $cpar->person_responsible  }}, last {{ $cpar->created_at->toDayDateTimeString() }},
    have been unanswered and expired {{ $cpar->updated_at->toDayDateTimeString() }}.

    @slot('subcopy')
        <p style="text-align: center;">This is a computer generated email. Please do not reply. For inquiries kindly email as at <a href="#">it@newsim.ph</a></p>
    @endslot

@endcomponent


