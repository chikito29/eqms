<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\Mail\CparCreated;
use App\Mail\CparFinalized;
use App\Mail\CparReviewed as ReviewedCpar;
use App\Mail\CparAnswered as AnsweredCpar;
use App\ResponsiblePerson;
use App\Section;
use App\Document;
use Carbon\Carbon;
use App\Attachment;
use App\CparClosed;
use App\CparAnswered;
use App\CparReviewed;
use App\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CparController extends Controller {
    protected $cpars;
    protected $businessDays;

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
            'tags'               => 'required',
            'other-source'       => 'required',
            'details'            => 'required',
            'person-responsible' => 'required',
            'proposed-date'      => 'required',
            'department-head'    => 'required',
        ]);

        if (request('branch') == '') {
            session([
                'branch' => 'Woops! Looks like you forgot to choose a branch.'
            ]);

            return back()->withInput();
        }

        if (request('severity') == 'Observation') {
            $severity = '<span class="label label-info">' . request('severity') . '</span>';
        }
        elseif (request('severity') == 'Minor') {
            $severity = '<span class="label label-warning">' . request('severity') . '</span>';
        }
        else {
            $severity = '<span class="label label-danger">' . request('severity') . '</span>';
        }

        $code = str_random(24);

        $cpar = Cpar::create([
            'raised_by'          => request('raised-by'),
            'department'         => request('department'),
            'branch'             => request('branch'),
            'severity'           => $severity,
            'document_id'        => request('reference'),
            'tags'               => request('tags'),
            'source'             => request('source'),
            'other_source'       => request('other-source'),
            'details'            => request('details'),
            'person_reporting'   => request('raised-by'),
            'person_responsible' => request('person-responsible'),
            'proposed_date'      => request('proposed-date'),
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
        $cpar->cpar_closed_id   = $cparClosed->cpar_id;
        $cpar->save();

        DocumentVersion::create([
            'cpar_id'  => $cpar->id,
            'document' => $document->body
        ]);

        ResponsiblePerson::create([
            'cpar_id' => $cpar->id,
            'code'    => $code
        ]);

        Mail::to('department-head@newsim.ph')->send(new CparCreated($cpar->id));

        return redirect('cpars');
    }

    public function show(Cpar $cpar) {
        $sections     = Section::with('documents')->get();
        $documentBody = $this->getDocument($cpar);

        return view('cpars.show', compact('cpar', 'sections', 'documentBody'));
    }

    public function edit(Cpar $cpar) {
        $sections = Section::with('documents')->get();

        return view('cpars.edit', compact('cpar', 'sections'));
    }

    public function update(Cpar $cpar) {
        $this->validate(request(), [
            'tags'               => 'required',
            'details'            => 'required',
            'person-responsible' => 'required',
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

        $cpar->person_responsible = request('person-responsible');
        $cpar->root_cause         = request('root-cause');
        $cpar->severity           = $severity;
        $cpar->department         = request('department');
        $cpar->proposed_date      = request('proposed-date');
        $cpar->severity           = request('severity');
        $cpar->document_id        = request('reference');
        $cpar->tags               = request('tags');
        $cpar->source             = request('source');
        $cpar->other_source       = request('other-source');
        $cpar->details            = request('details');
        $cpar->department_head    = request('department-head');
        $cpar->save();

        return redirect()->route('cpars.show', ['cpar' => $cpar->id]);
    }

    public function close(Cpar $cpar) {
        $cparClosed            = CparClosed::find($cpar->id);
        $cparClosed->status    = 1;
        $cparClosed->closed_by = request('user.first_name') . ' ' . request('user.last_name');
        $cparClosed->save();

        return back();
    }

    public function answerCpar(Cpar $cpar) {
        if ($cpar->responsiblePerson->trashed()) {
            return redirect('cpar-answer-login')->withErrors(['code' => 'It seems like you already answer this CPAR, if you want an access to it, please contact QMR.']);
        }
        elseif ($cpar->responsiblePerson->authenticated == 1) {
            $due                = Carbon::parse($cpar->proposed_date);
            $due                = $due->diffInDays($cpar->created_at);
            $this->businessDays = $due + 1;

            if ($cpar->cparReviewed->on_review == 1) {
                return redirect("cpar-on-review/$cpar->id");
            }
            elseif ($cpar->cparClosed->status == 1) {
                return redirect("cpar-on-review/$cpar->id");
            }

            $documentBody = $this->getDocument($cpar);
            $dueDate      = $this->holidays($cpar, 2017);
            $due          = $this->businessDays;

            return view('cpars.answer-cpar', compact('cpar', 'documentBody', 'dueDate', 'due'));
        }
        else {
            return redirect("answer-cpar/login/$cpar->id");
        }
    }

    public function getDocument($cpar) {
        $documentTags = explode(',', $cpar->tags);
        $documentBody = $cpar->documentVersion->document;
        $stripDoc     = str_replace('&nbsp;', '', $documentBody);
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

        $dateCreated = $cpar->created_at->startOfDay();

        for ($i = 0; $i < $this->businessDays; $i++) {
            $tempDate = $dateCreated->addDay();
            foreach ($holidays as $holiday) {
                if ($holiday->startOfDay()->eq($tempDate->startOfDay())) {
                    $this->businessDays = $this->businessDays + 1;
                    break;
                }
            }
        }

        return $cpar->created_at->addDays($this->businessDays);
    }

    public static function holiday($cpar, $year, $lastDay, $due) {
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
        $dateCreated  = $cpar->created_at->startOfDay();
        $lastDay      = $lastDay->startOfDay();

        for ($i = 0; $i < $due; $i++) {
            $tempDate = $dateCreated->addDay();
            foreach ($holidays as $holiday) {
                if ($holiday->startOfDay()->eq($tempDate->startOfDay()) && $tempDate->day <> 0) $businessDays++;
            }
            if ($dateCreated->eq($lastDay)) {
                break;
            }
        }

        return $dateCreated->addDays($businessDays);
    }

    public function answer(Cpar $cpar) {
        $this->validate(request(), [
            'correction' => 'required',
            'root-cause' => 'required',
            'cp-action'  => 'required',
        ]);

        if (request()->hasFile('attachments')) {
            $files = request()->file('attachments');
            foreach ($files as $key => $file) {
                $path                    = $file->store('attachments', 'public');
                $attachment              = new Attachment();
                $attachment->cpar_id     = $cpar->id;
                $attachment->file_name   = 'attachment_' . ($key + 1);
                $attachment->file_path   = 'storage/' . $path;
                $attachment->section     = 'answer';
                $attachment->uploaded_by = request('user.first_name') . ' ' . request('user.last_name');
                $attachment->save();
            }
        }

        $cpar->correction = request('correction');
        $cpar->cp_action  = request('cp-action');
        $cpar->root_cause = request('root-cause');
        $cpar->save();

        $cparAnswered = CparAnswered::find($cpar->id);
        //update status
        $cparAnswered->status   = 1;
        $cparAnswered->notified = 1;
        $cparAnswered->save();

        $cpar->date_accepted = $cpar->cparAnswered->created_at;
        $cpar->save();

        Mail::to('department-head@newsim.ph')->send(new AnsweredCpar($cpar->id));

        return redirect("cpar-on-review/$cpar->id");
    }

    public function onReview(Cpar $cpar) {
        $due                = Carbon::parse($cpar->proposed_date);
        $due                = $due->diffInDays($cpar->created_at);
        $this->businessDays = $due + 1;

        $dueDate = $this->holidays($cpar, 2017);

        return view('cpars.cpar-on-review', compact('cpar', 'dueDate'));
    }

    public function review(Cpar $cpar) {
        $sections     = Section::with('documents')->get();
        $documentBody = $this->getDocument($cpar);

        return view('cpars.review', compact('cpar', 'sections', 'documentBody'));
    }

    public function saveReview(Cpar $cpar) {
        $this->validate(request(), [
            'cpar-number'       => 'required',
            'date-completed'    => 'required',
            'cpar-acceptance'   => 'required',
            'date-accepted'     => 'required',
            'verified-by'       => 'required',
            'verification-date' => 'required',
            'result'            => 'required',
        ]);

        $cparReviewed = CparReviewed::find($cpar->id);
        //update on review and reviewed by
        $cparReviewed->status      = 1;
        $cparReviewed->notified    = 1;
        $cparReviewed->reviewed_by = request('user.first_name') . ' ' . request('user.last_name');
        $cparReviewed->save();

        $cparClosed = CparClosed::find($cpar->id);
        //close reviewed cpar
        $cparClosed->status    = 1;
        $cparClosed->notified  = 1;
        $cparClosed->closed_by = request('user.first_name') . ' ' . request('user.last_name');
        $cparClosed->remarks   = "";
        $cparClosed->save();

        //save cpar
        $cpar->cpar_acceptance = request('cpar-acceptance');
        $cpar->cpar_number     = request('cpar-number');
        $cpar->date_verified   = request('verification-date');
        $cpar->date_accepted   = request('date-accepted');
        $cpar->date_completed  = request('date-completed');
        $cpar->verified_by     = request('verified-by');
        $cpar->result          = request('result');
        $cpar->cp_action       = request('cp-action');
        $cpar->save();

        //notify department head
        Mail::to('department-head@newsim.ph')->send(new ReviewedCpar($cpar->id));

        return redirect()->route('cpars.index');
    }

    public function verify(Cpar $cpar) {
        if ($cpar->cparClosed->status <> 1) {
            $sections     = Section::with('documents')->get();
            $documentBody = $this->getDocument($cpar);

            $cparReviewed            = CparReviewed::find($cpar->id);
            $cparReviewed->on_review = 1;
            $cparReviewed->save();

            return view('cpars.verify', compact('cpar', 'sections', 'documentBody'));
        }
        else {
            return route('cpars.cpar-on-review', $cpar->id);
        }
    }

    public function finalize(Cpar $cpar) {
        $cpar->date_confirmed = Carbon::now();
        $cpar->save();

        //notify department head
        Mail::to('qmr@newsim.ph')->send(new CparFinalized($cpar->id));

        return redirect('cpars');
    }

    public function saveAsDraft(Cpar $cpar) {

    }
}
