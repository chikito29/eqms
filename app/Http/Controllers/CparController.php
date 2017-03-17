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
        $this->middleware('na.authenticate');
    }

    public function index() {
        return view('cpars.index')->with('cpars', $this->cpars->get());
    }

    public function create() {
        $sections = Section::with('documents')->get();

        return view('cpars.create', compact('sections'));
    }

    public function store() {
        //TODO: extract this validation to the model
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

        //TODO: put this method in verifying section
        /*if (request('attachments')) {
            $files = request('attachments');
            foreach ($files as $file) {
                $path = $file->store('attachments', 'public');
                $attachment = new Attachment();
                $attachment->cpar_id = $cpar->id;
                $attachment->file_name = 'storage/' . $path;
                $attachment->uploaded_by = request('user.first_name') . ' ' . request('user.last_name');
                $attachment->save();
            }
        }*/

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

    public function show(Cpar $cpar) {
        $sections = Section::with('documents')->get();
        $documentBody = $this->getDocument($cpar);

        return view('cpars.show', compact('cpar', 'sections', 'documentBody'));
    }

    public function edit(Cpar $cpar) {
        $sections = Section::with('documents')->get();

        return view('cpars.edit', compact('cpar', 'sections'));
    }

    public function update(Request $request, Cpar $cpar) {
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

        $cpar->cpar_number = request('cpar-number');
        $cpar->raised_by = request('raised-by');
        $cpar->department = request('department');
        $cpar->severity = $severity;
        $cpar->document_id = request('reference');
        $cpar->tags = request('tags');
        $cpar->source = request('source');
        $cpar->other_source = request('other-source');
        $cpar->details = request('details');
        $cpar->person_reporting = request('person-reporting');
        $cpar->person_responsible = request('person-responsible');
        $cpar->root_cause = request('root-cause');
        $cpar->department_head = request('department-head');
        $cpar->save();

        DocumentVersion::create([
            'cpar_id'        => $cpar->id,
            'control_number' => "adadasd",
            'document'       => $document->body
        ]);

        return redirect()->route('cpars.show', ['cpar' => $cpar->id]);
    }

    public function destroy(Cpar $cpar) {
        //
    }

    public function answerCpar(Cpar $cpar) {
        if ($cpar->cparReviewed->on_review == 1) {
            return view('cpars.cpar-on-review');
        }

        $documentBody = $this->getDocument($cpar);
        $dueDate = $this->holidays($cpar, 2017);

        return view('cpars.answer-cpar', compact('cpar', 'documentBody', 'dueDate'));
    }

    public function getDocument($cpar) {
        $documentTags = explode(',', $cpar->tags);
        $documentBody = $cpar->documentVersion->document;
        $stripDoc = str_replace('&nbsp;', '', $documentBody);
        foreach ($documentTags as $tag) {
            $stripDoc = str_replace(preg_replace('!\s+!', ' ', $tag), '<span style="background-color: yellow;">' . $tag . '</span>', $stripDoc);
        }

        return $stripDoc;
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
        $cpar->save();

        $cparAnswered = CparAnswered::find($cpar->id);
        $cparAnswered->status = 1;
        $cparAnswered->save();

        $cpar->date_accepted = $cpar->cparAnswered->created_at;
        $cpar->save();

        return redirect('cpar-on-review');
    }

    public function onReview() {
        return view('cpars.cpar-on-review');
    }

    public function review(Cpar $cpar) {
        $sections = Section::with('documents')->get();

        return view('cpars.review', compact('cpar', 'sections'));
    }

    public function saveReview(Cpar $cpar) {
        $cparReviewed = CparReviewed::find($cpar->id);
        $cparReviewed->on_review = 1;
        $cparReviewed->reviewed_by = request('user.first_name') . ' ' . request('user.last_name');
        $cparReviewed->save();

        $this->validate(request(), [
            'cpar-acceptance'   => 'required',
            'name'              => 'required',
            'verification-date' => 'required',
            'result'            => 'required',
        ]);

        $cpar->cpar_acceptance = request('cpar-acceptance');
        $cpar->date_verified = request('verification-date');
        $cpar->verified_by = request('verified-by');
        $cpar->result = request('result');
        $cpar->save();

        return redirect()->route('cpars.index');
    }
}
