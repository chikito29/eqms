@if($cpar->cparClosed->status == 1 && $cpar->cparReviewed->status <> 1)
    <span class="label label-primary">Closed {{ $cpar->cparClosed->created_at->diffForHumans() }}
        closed by {{ $cpar->cparClosed->closed_by }} {{ $cpar->cparClosed->remarks }}</span>
@elseif($cpar->cparClosed->status == 1 && $cpar->cparReviewed->status == 1)
    <span class="label label-warning">CPAR reviewed and closed {{ 	$cpar->cparClosed->created_at->diffForHumans() }}
        by {{ $cpar->cparClosed->closed_by }}</span>
@elseif($cpar->cparReviewed->on_review == 1)
    <span class="label label-warning">CPAR on review {{ $cpar->cparReviewed->updated_at->diffForHumans() }}</span>
@elseif($cpar->cparAnswered->status == 1 && $cpar->cparReviewed->status == 1)
    <span class="label label-success">Reviewed {{ $cpar->cparReviewed->created_at->diffForHumans() }} by {{ $cpar->cparReviewed->reviewed_by }}</span>
@elseif($cpar->cparAnswered->status <> 1)
    <span class="label label-danger">No Response. Issued {{ $cpar->created_at->diffForHumans() }}</span>
@else
    <span class="label label-success">CPAR answered {{ $cpar->cparAnswered->created_at->diffForHumans() }}</span>
@endif
