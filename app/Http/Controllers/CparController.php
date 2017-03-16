<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\Section;
use App\Document;
use Carbon\Carbon;
use App\CparClosed;
use App\CparAnswered;
use App\CparReviewed;
use App\DocumentVersion;
use Illuminate\Http\Request;

class CparController extends Controller {
    protected $cpars;

    function __construct(Cpar $cpars) {
        $this->cpars = $cpars->latest();
    }

    public function index() {
        return view('cpars.index')->with('cpars', $this->cpars->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $sections = Section::with('documents')->get();

        return view('cpars.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store() {
        $document = Document::find(request('reference'));

        $this->validate(request(), [
            'cpar-number'        => 'required',
            'raised-by'          => 'required',
            'tags'               => 'required',
            'details'            => 'required',
            'person-responsible' => 'required',
            'root-cause'         => 'required',
        ]);

        if (request('severity') == 'Observation') {
            $severity = '<span class="label label-info">' . request('severity') . '</span>';
        }
        elseif (request('severity') == 'Minor') {
            $severity = '<span class="label label-warning">' . request('severity') . '</span>';
        }
        else {
            $severity = '<span class="label label-danger">' . request('severity') . '</span>';
        }

        $cpar = Cpar::create([
            'cpar_number'        => request('cpar-number'),
            'raised_by'          => request('raised-by'),
            'department'         => request('department'),
            'severity'           => $severity,
            'document_id'        => request('reference'),
            'tags'               => request('tags'),
            'source'             => request('source'),
            'other_source'       => request('other-source'),
            'details'            => request('details'),
            'person_reporting'   => request('person-reporting'),
            'person_responsible' => request('person-responsible'),
            'root_cause'         => request('root-cause'),
            'department_head'    => request('department-head')
        ]);

        if (request('attachments')) {
            $files = request('attachments');
            foreach ($files as $file) {
                $path = $file->store('attachments', 'public');
                $attachment = new Attachment();
                $attachment->cpar_id = $cpar->id;
                $attachment->file_name = 'storage/' . $path;
                $attachment->uploaded_by = request('user.first_name') . ' ' . request('user.last_name');
                $attachment->save();
            }
        }

        $cparAnswered = CparAnswered::create([
            'cpar_id' => $cpar->id
        ]);

        $cparReviewed = CparReviewed::create([
            'cpar_id' => $cpar->id
        ]);

        $cparClosed = CparClosed::create([
            'cpar_id' => $cpar->id
        ]);

        $cpar->cpar_answered_id = $cparAnswered->id;
        $cpar->cpar_reviewed_id = $cparReviewed->id;
        $cpar->cpar_closed_id = $cparClosed->id;
        $cpar->save();

        DocumentVersion::create([
            'cpar_id'        => $cpar->id,
            'control_number' => "adadasd",
            'document'       => $document->body
        ]);

        return redirect('cpars');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cpar $cpar
     * @return \Illuminate\Http\Response
     */
    public function show(Cpar $cpar) {
        $sections = Section::with('documents')->get();
        $documentBody = $this->getDocument($cpar);

        return view('cpars.show', compact('cpar', 'sections', 'documentBody'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cpar $cpar
     * @return \Illuminate\Http\Response
     */
    public function edit(Cpar $cpar) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Cpar $cpar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cpar $cpar) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cpar $cpar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cpar $cpar) {
        //
    }

    public function answerCpar(Cpar $cpar) {
        if($cpar->cparReviewed->on_review == 1){
            return view('cpars.cpar-on-review');
        }

        $documentBody = $this->getDocument($cpar);
        $dueDate = $this->holidays($cpar, 2017);

        return view('cpars.answer-cpar', compact('cpar', 'documentBody', 'dueDate'));
    }

    public function getDocument($cpar) {

        $documentTags = explode(',', $cpar->tags);
        $documentBody = $cpar->documentVersion->document;
        foreach ($documentTags as $tag) {
            $documentBody = str_replace(preg_replace('!\s+!', ' ', $tag), '<span style="background-color: yellow;">' . $tag . '</span>', str_replace('&nbsp;', '', $documentBody));
        }

        return $documentBody;
    }

    public function holidays($cpar, $year) {
        $holidays = [
            Carbon::createFromDate($year, 1, 1), // New Year's Day
            Carbon::createFromDate($year, 1, 2), // Public Holiday
            Carbon::createFromDate($year, 1, 28), // Chinese New Year
            Carbon::createFromDate($year, 2, 25), // People Power Revolution
            Carbon::createFromDate($year, 4, 9), // The Day Of Valor
            Carbon::createFromDate($year, 4, 13), // Maundy Thursday
            Carbon::createFromDate($year, 4, 14), // Good Friday
            Carbon::createFromDate($year, 4, 15), // Black Saturday
            Carbon::createFromDate($year, 5, 1), // Labor Day
            Carbon::createFromDate($year, 6, 12), // Independence Day
            Carbon::createFromDate($year, 6, 26), // Eid-UI-Fitr
            Carbon::createFromDate($year, 8, 21), // Ninoy Aquino Day
            Carbon::createFromDate($year, 8, 28), // National Heroes Day
            Carbon::createFromDate($year, 9, 1), // Eid-Al-Adha
            Carbon::createFromDate($year, 10, 31), // Public Holiday
            Carbon::createFromDate($year, 1, 1), // All Saints Day
            Carbon::createFromDate($year, 1, 30), // Bonifacio Day
            Carbon::createFromDate($year, 12, 25), // Christmas Day
            Carbon::createFromDate($year, 12, 30), // Rizal Day
            Carbon::createFromDate($year, 12, 31) // New Year's Eve
        ];

        $businessDays = 0;
        $dueDate = $cpar->created_at->startOfDay();

        for ($i = 0; $i < 10; $i++) {
            $tempDate = $dueDate->addDay();
            foreach ($holidays as $holiday) {
                if ($holiday->startOfDay()->eq($tempDate) && $tempDate->day <> 0) $businessDays++;
            }
        }

        return $dueDate->addDays($businessDays);
    }

    public function answer(Cpar $cpar) {
        $this->validate(request(), [
            'correction'    => 'required|min:100',
            'cp-action'     => 'required|min:100',
            'proposed-date' => 'required|after:' . Carbon::now()->toFormattedDateString(),
        ]);

        $cpar->correction = request('correction');
        $cpar->cp_action = request('cp-action');
        $cpar->proposed_date = request('proposed-date');
        $cpar->cparAnswered->status = 1;
        $cpar->save();

        $cpar->date_accepted = $cpar->cparAnswered->created_at;
        $cpar->save();

        return redirect('cpar-on-review');
    }

    public function onReview() {
        return view('cpars.cpar-on-review');
    }
}
