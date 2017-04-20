<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\EqmsUser;
use App\Mail\CparCreated;
use App\Mail\CparFinalized;
use App\Mail\CparReviewed as ReviewedCpar;
use App\Mail\CparAnswered as AnsweredCpar;
use App\NA;
use App\ResponsiblePerson;
use App\Section;
use App\Document;
use Carbon\Carbon;
use App\Attachment;
use App\CparClosed;
use App\CparAnswered;
use App\CparReviewed;
use App\DocumentVersion;
use Illuminate\Support\Facades\Mail;

class CparController extends Controller {
    protected $cpars;
    protected $eqmsUsers;
    protected $businessDays;

    function __construct(Cpar $cpars, EqmsUser $eqmsUsers) {
        $this->eqmsUsers = $eqmsUsers->all();
        $this->cpars     = $cpars->latest()->get();
        $this->middleware('na.authenticate')->except(['answerCpar', 'answer']);
    }

    public function getEmail($id) {
        return $employee = NA::user($id)->email;
    }

    public function index() {
        $user = $this->eqmsUsers->where('user_id', request('user.id'));
        foreach($user as $authUser) {
            $user = $authUser;
        }
        return view('cpars.index', ['cpars' => $this->cpars, 'user' => $user]);
    }

    public function create() {
        $sections = Section::with('documents')->get();
        $users    = NA::users();

        return view('cpars.create', ['sections' => $sections, 'users' => $users]);
    }

    public function store() {
        //TODO: extract this validation to the model
        $document = Document::find(request('reference'));

        $this->validate(request(), [
            'tags'               => 'required',
            'other_source'       => 'required',
            'details'            => 'required',
            'person_responsible' => 'required',
            'proposed_date'      => 'required',
            'chief'              => 'required',
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
            'raised_by'          => request('raised_by'),
            'department'         => request('department'),
            'branch'             => request('branch'),
            'severity'           => $severity,
            'document_id'        => request('reference'),
            'tags'               => request('tags'),
            'source'             => request('source'),
            'other_source'       => request('other_source'),
            'details'            => request('details'),
            'person_reporting'   => request('raised_by'),
            'person_responsible' => request('person_responsible'),
            'proposed_date'      => request('proposed_date'),
            'chief'              => request('chief')
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

        ResponsiblePerson::create([
            'cpar_id' => $cpar->id,
            'user_id' => $cpar->person_responsible,
            'code'    => $code
        ]);

        session()->flash('notify', ['message' => 'CPAR successfully created.', 'type' => 'success']);

        Mail::to($this->getEmail($cpar->chief))->send(new CparCreated($cpar->id));

        return redirect()->route('cpars.index');
    }

    public function show(Cpar $cpar) {
        $sections = Section::with('documents')->get();

        $document = Document::find($cpar->document_id);
        $body = $document->body;
        $tags = explode(',', $cpar->tags);

        foreach ($tags as $tag){
            $body = str_ireplace($tag, '<mark style="background-color: yellow;">' . ucfirst($tag) . '</mark>', $body);
        }

        session()->flash('attention', ['body' => '<strong class="text text-danger">Disclaimer</strong>: If the <strong>Document Reference</strong> does not show any <strong>highlighting</strong>, this means that the target
                                      <strong>document section</strong> has already been <strong>revised</strong> or <strong>deleted</strong>.
                                      Please refer to <strong>Tags</strong> instead.', 'color' => 'info']);

        return view('cpars.show', compact('cpar', 'sections', 'body'));
    }

    public function edit(Cpar $cpar) {
        $sections = Section::with('documents')->get();

        return view('cpars.edit', compact('cpar', 'sections'));
    }

    public function update(Cpar $cpar) {
        $this->validate(request(), [
            'tags'               => 'required',
            'details'            => 'required',
            'person_responsible' => 'required',
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

        $cpar->person_responsible = request('person_responsible');
        $cpar->root_cause         = request('root_cause');
        $cpar->severity           = $severity;
        $cpar->department         = request('department');
        $cpar->proposed_date      = request('proposed_date');
        $cpar->severity           = request('severity');
        $cpar->document_id        = request('reference');
        $cpar->tags               = request('tags');
        $cpar->source             = request('source');
        $cpar->other_source       = request('other_source');
        $cpar->details            = request('details');
        $cpar->chief              = request('department_head');
        $cpar->save();

        session()->flash('notify', ['message' => 'CPAR successfully updated.', 'type' => 'success']);

        return redirect()->route('cpars.show', ['cpar' => $cpar->id]);
    }

    public function close(Cpar $cpar) {
        $cparClosed            = CparClosed::find($cpar->id);
        $cparClosed->status    = 1;
        $cparClosed->closed_by = request('user.first_name') . ' ' . request('user.last_name');
        $cparClosed->save();

        session()->flash('notify', ['message' => 'CPAR has been closed.', 'type' => 'success']);

        return back();
    }

    public function answerCpar(Cpar $cpar) {
        $due                = Carbon::parse($cpar->proposed_date);
        $due                = $due->diffInDays($cpar->created_at);
        $this->businessDays = $due + 1;

        if ($cpar->cparClosed->status == 1) {
            return redirect("cpar-on-review/$cpar->id")->withErrors(['code' => 'CPAR is already closed.']);
        }
        elseif ($cpar->cparReviewed->on_review == 1) {
            return redirect("cpar-on-review/$cpar->id")->withErrors(['code' => 'CPAR is already on review.']);
        }

        $document = Document::find($cpar->document_id);
        $body = $document->body;
        $tags = explode(',', $cpar->tags);

        foreach ($tags as $tag){
            $body = str_ireplace($tag, '<mark style="background-color: yellow;">' . ucfirst($tag) . '</mark>', $body);
        }

        $dueDate = $this->holidays($cpar, 2017);
        $due     = $this->businessDays;

        return view('cpars.answer-cpar', compact('cpar', 'body', 'dueDate', 'due'));
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
            'root_cause' => 'required',
            'cp_action'  => 'required',
        ]);

        $responsiblePerson = collect(NA::user($cpar->responsiblePerson->user_id));

        if (request()->hasFile('attachments')) {
            $files = request()->file('attachments');
            foreach ($files as $key => $file) {
                $path                    = $file->store('attachments', 'public');
                $attachment              = new Attachment();
                $attachment->cpar_id     = $cpar->id;
                $attachment->file_name   = 'attachment_' . ($key + 1);
                $attachment->file_path   = 'storage/' . $path;
                $attachment->section   = 'answer';
                $attachment->uploaded_by = $responsiblePerson['first_name'] .' '. $responsiblePerson['last_name'];
                $attachment->save();
            }
        }

        $cpar->correction = request('correction');
        $cpar->cp_action  = request('cp_action');
        $cpar->root_cause = request('root_cause');
        $cpar->save();

        $cparAnswered = CparAnswered::find($cpar->id);
        //update status
        $cparAnswered->status   = 1;
        $cparAnswered->notified = 1;
        $cparAnswered->save();

        $cpar->date_accepted = $cpar->cparAnswered->created_at;
        $cpar->save();

        Mail::to($this->getEmail($cpar->chief))->send(new AnsweredCpar($cpar->id));

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
        $admin = $this->eqmsUsers->where('user_id', request('user.id'));
        if($admin->count() != 0) {
            if($admin[0]['role'] == 'Admin') {
                $sections = Section::with('documents')->get();

                $document = Document::find($cpar->document_id);
                $body = $document->body;
                $tags = explode(',', $cpar->tags);

                foreach ($tags as $tag){
                    $body = str_ireplace($tag, '<mark style="background-color: yellow;">' . ucfirst($tag) . '</mark>', $body);
                }

                return view('cpars.review', compact('cpar', 'sections', 'body'));
            } else {
                return view('errors.404');
            }
        } else {
            return view('errors.404');
        }
    }

    public function saveReview(Cpar $cpar) {
        $this->validate(request(), [
            'date_completed'    => 'required',
            'cpar_acceptance'   => 'required',
            'date_accepted'     => 'required',
            'verified_by'       => 'required',
            'verification_date' => 'required',
            'result'            => 'required',
        ]);

        //save cpar
        $cpar->cpar_acceptance = request('cpar_acceptance');
        $cpar->date_verified   = request('verification_date');
        $cpar->date_accepted   = request('date_accepted');
        $cpar->date_completed  = request('date_completed');
        $cpar->verified_by     = request('verified_by');
        $cpar->result          = request('result');
        $cpar->save();

        $user = NA::user($cpar->person_responsible);

        $cparReviewed = CparReviewed::where('cpar_id', $cpar->id)->first();
        $cparReviewed->status;
        $cparReviewed->save();

        if (request()->hasFile('attachments')) {
            $files = request()->file('attachments');
            foreach ($files as $key => $file) {
                $path                    = $file->store('attachments', 'public');
                $attachment              = new Attachment();
                $attachment->cpar_id     = $cpar->id;
                $attachment->file_name   = 'attachment_' . (Attachment::where('cpar_id', $cpar->id)->get()->count() + 1);
                $attachment->file_path   = 'storage/' . $path;
                $attachment->section   = 'review';
                $attachment->uploaded_by = $user->first_name .' '. $user->last_name;
                $attachment->save();
            }
        }

        session()->flash('attention', ['body' => '<strong>To finalize the CPAR that has been reviewed</strong>, the Document Controller needs to add its <strong>CPAR Number</strong>', 'color' => 'info']);

        return redirect()->route('cpars.index');
    }

    public function verify(Cpar $cpar) {
        if ($cpar->chief == request('user.id')) {
            if ($cpar->cparClosed->status <> 1 && $cpar->date_confirmed == NULL) {
                $sections = Section::with('documents')->get();

                $cparReviewed            = CparReviewed::find($cpar->id);
                $cparReviewed->on_review = 1;
                $cparReviewed->save();

                $document = Document::find($cpar->document_id);
                $body = $document->body;
                $tags = explode(',', $cpar->tags);

                foreach ($tags as $tag){
                    $body = str_ireplace($tag, '<mark style="background-color: yellow;">' . ucfirst($tag) . '</mark>', $body);
                }

                return view('cpars.verify', compact('cpar', 'sections', 'body'));
            }
            else {
                return redirect()->route('cpars.on-review', $cpar->id);
            }
        }
        else {
            return view('errors.404');
        }
    }

    public function finalize(Cpar $cpar) {
        $cpar->date_confirmed = Carbon::now();
        $cpar->save();

        $responsiblePerson = ResponsiblePerson::where('user_id', $cpar->person_responsible);
        $responsiblePerson->delete();

        //notify QMR head
        Mail::to('qmr@newsim.ph')->send(new CparFinalized($cpar->id));

        return redirect('cpars');
    }

    public function saveAsDraft(Cpar $cpar) {
        //save cpar
        $cpar->cpar_acceptance = request('cpar_acceptance');
        $cpar->cpar_number     = request('cpar_number');
        $cpar->date_verified   = request('verification_date');
        $cpar->date_accepted   = request('date_accepted');
        $cpar->date_completed  = request('date_completed');
        $cpar->verified_by     = request('verified_by');
        $cpar->result          = request('result');
        $cpar->save();

        session()->flash('notify', ['message' => 'CPAR draft has been saved.', 'type' => 'success']);

        return back();
    }

    public function createCparNumber($cpar) {
        $updateCpar = Cpar::find($cpar);

       $this->validate(request(), [
            'cpar_number' => 'required|unique:cpars,cpar_number'
        ]);

        $updateCpar->cpar_number = request('cpar_number');
        $updateCpar->save();

        $cparReviewed = CparReviewed::find($cpar);
        //update on review and reviewed by
        $cparReviewed->status      = 1;
        $cparReviewed->notified    = 1;
        $cparReviewed->reviewed_by = request('user.first_name') . ' ' . request('user.last_name');
        $cparReviewed->save();

        $cparClosed = CparClosed::find($cpar);
        //close reviewed cpar
        $cparClosed->status    = 1;
        $cparClosed->notified  = 1;
        $cparClosed->closed_by = request('user.first_name') . ' ' . request('user.last_name');
        $cparClosed->remarks   = "";
        $cparClosed->save();

        //notify department head
        Mail::to($this->getEmail($updateCpar->chief))->send(new ReviewedCpar($cpar));

        session()->flash('notify', ['message' => 'CPAR number successfully added.', 'type' => 'success']);

        return back();
    }
}
