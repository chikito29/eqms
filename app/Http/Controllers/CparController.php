<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\EqmsUser;
use App\HelperClasses\Make;
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
use Illuminate\Http\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CparController extends Controller {
  protected $cpars;

  function __construct(Cpar $cpars, EqmsUser $eqmsUsers) {
    $this->cpars = $cpars->latest()->get();
    $this->middleware('na.authenticate')->except(['answerCpar', 'answer']);
  }

  public function getEmail($id) {
    return $employee = NA::user($id)->email;
  }

  public function colorize($severity) {
    if ($severity == 'Observation') {
      $severity = '<span class="label label-info">' . $severity . '</span>';
    }
    elseif ($severity == 'Minor') {
      $severity = '<span class="label label-warning">' . $severity . '</span>';
    }
    else {
      $severity = '<span class="label label-danger">' . $severity . '</span>';
    }

    return $severity;
  }

  public function index() {
    Make::log(
        'visited CPARs index',
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    $cpars = Cpar::paginate(10);

    return view('cpars.index', ['cpars' => $cpars]);
  }

  public function create() {
    Make::log(
        'visited CPAR creation page',
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    $sections = Section::with('documents')->get();
    $users    = NA::users();

    return view('cpars.create', ['sections' => $sections, 'users' => $users]);
  }

  public function store() {
    Make::log(
        'tried to create a CPAR',
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

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

    $severity = $this->colorize(request('severity'));
    $code     = str_random(24);

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

    $personResponsible = collect(NA::user(request('person_responsible')));

    if (request()->hasFile('attachments')) {
      $files = request()->file('attachments');
      foreach ($files as $key => $file) {
        $sequence                = Attachment::where('cpar_id', $cpar->id)->select('id')->get()->count() + 1;
        $path                    = Storage::putFile('attachments', new File($file));
        $attachment              = new Attachment();
        $attachment->cpar_id     = $cpar->id;
        $attachment->file_name   = 'attachment_' . $sequence;
        $attachment->file_path   = 'storage/' . $path;
        $attachment->section     = 'create';
        $attachment->uploaded_by = $personResponsible['first_name'] . ' ' . $personResponsible['last_name'];
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
    $cpar->cpar_closed_id   = $cparClosed->cpar_id;
    $cpar->save();

    ResponsiblePerson::create([
        'cpar_id' => $cpar->id,
        'user_id' => $cpar->person_responsible,
        'code'    => $code
    ]);

    session()->flash('notify', ['message' => 'CPAR successfully created.', 'type' => 'success']);
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'successfully created a CPAR for ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    Mail::to($this->getEmail($cpar->chief))->send(new CparCreated($cpar->id));

    return redirect()->route('cpars.index');
  }

  public function show(Cpar $cpar) {
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'viewed CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    $sections = Section::with('documents')->get();

    $document = Document::find($cpar->document_id);
    $body     = str_replace('&nbsp;', '', $document->body);
    $tags     = explode(',', $cpar->tags);

    foreach ($tags as $tag) {
      $body = str_ireplace($tag, '<mark style="background-color: yellow;">' . ucfirst($tag) . '</mark>', $body);
    }

    session()->flash('attention', ['body' => '<strong class="text text-danger">Disclaimer</strong>: If the <strong>Document Reference</strong> does not show any <strong>highlighting</strong>, this means that the target
                                      <strong>document section</strong> has already been <strong>revised</strong> or <strong>deleted</strong>.
                                      Please refer to <strong>Tags</strong> instead.', 'color' => 'info']);

    return view('cpars.show', compact('cpar', 'sections', 'body'));
  }

  public function edit(Cpar $cpar) {
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'visited editing page for the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    $sections = Section::with('documents')->get();

    return view('cpars.edit', compact('cpar', 'sections'));
  }

  public function update(Cpar $cpar) {
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'tried to update CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    $this->validate(request(), [
        'tags'               => 'required',
        'details'            => 'required',
        'person_responsible' => 'required',
    ]);

    $severity = $this->colorize(request('severity'));

    $cpar->severity           = $severity;
    $cpar->person_responsible = request('person_responsible');
    $cpar->root_cause         = request('root_cause');
    $cpar->department         = request('department');
    $cpar->proposed_date      = request('proposed_date');
    $cpar->document_id        = request('reference');
    $cpar->tags               = request('tags');
    $cpar->source             = request('source');
    $cpar->other_source       = request('other_source');
    $cpar->details            = request('details');
    $cpar->chief              = request('department_head');
    $cpar->save();

    return $cpar;

    $responsiblePerson = collect(NA::user($cpar->responsiblePerson->user_id));

    if (request()->hasFile('attachments')) {
      $files = request()->file('attachments');
      foreach ($files as $key => $file) {
        $sequence                = Attachment::where('cpar_id', $cpar->id)->select('id')->get()->count() + 1;
        $path                    = Storage::putFile('attachments', new File($file));
        $attachment              = new Attachment();
        $attachment->cpar_id     = $cpar->id;
        $attachment->file_name   = 'attachment_' . $sequence;
        $attachment->file_path   = 'storage/' . $path;
        $attachment->section     = 'edited';
        $attachment->uploaded_by = request('user.first_name') . ' ' . user('user.last_name');
        $attachment->save();
      }
    }

    session()->flash('notify', ['message' => 'CPAR successfully updated.', 'type' => 'success']);
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'successfully updated CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    return redirect()->route('cpars.show', ['cpar' => $cpar->id]);
  }

  public function close(Cpar $cpar) {
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'closed CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    $cparClosed            = CparClosed::find($cpar->id);
    $cparClosed->status    = 1;
    $cparClosed->closed_by = request('user.first_name') . ' ' . request('user.last_name');
    $cparClosed->save();

    session()->flash('notify', ['message' => 'CPAR has been closed.', 'type' => 'success']);

    return back();
  }

  public function answerCpar(Cpar $cpar) {
    $due = Carbon::parse($cpar->proposed_date);
    $due = $due->diffInDays($cpar->created_at);

    if ($cpar->cparClosed->status == 1) {
      return redirect("cpar-on-review/$cpar->id")->withErrors(['code' => 'CPAR is already closed.']);
    }
    elseif ($cpar->cparReviewed->on_review == 1) {
      return redirect("cpar-on-review/$cpar->id")->withErrors(['code' => 'CPAR is already on review.']);
    }

    $document = Document::find($cpar->document_id);
    $body     = str_replace('&nbsp;', '', $document->body);
    $tags     = explode(',', $cpar->tags);

    foreach ($tags as $tag) {
      $body = str_ireplace($tag, '<mark style="background-color: yellow;">' . ucfirst($tag) . '</mark>', $body);
    }

    $due = Carbon::parse($cpar->proposed_date);
    $due = $due->diffInDays($cpar->created_at);

    return view('cpars.answer-cpar', compact('cpar', 'body', 'due'));
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
        $sequence                = Attachment::where('cpar_id', $cpar->id)->select('id')->get()->count() + 1;
        $path                    = Storage::putFile('attachments', new File($file));
        $attachment              = new Attachment();
        $attachment->cpar_id     = $cpar->id;
        $attachment->file_name   = 'attachment_' . $sequence;
        $attachment->file_path   = 'storage/' . $path;
        $attachment->section     = 'answer-cpar';
        $attachment->uploaded_by = $responsiblePerson['first_name'] . ' ' . $responsiblePerson['last_name'];
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
    $due = Carbon::parse($cpar->proposed_date);
    $due = $due->diffInDays($cpar->created_at);

    return view('cpars.cpar-on-review', compact('cpar', 'due'));
  }

  public function review(Cpar $cpar) {
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'visited reviewing page for the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    $admin = \App\EqmsUser::where('user_id', request('user.id'))->first();
    if ($admin != NULL) {
      if ($admin->role == 'Admin') {
        $sections = Section::with('documents')->get();

        $document = Document::find($cpar->document_id);
        $body     = $document->body;
        $tags     = explode(',', $cpar->tags);

        foreach ($tags as $tag) {
          $body = str_ireplace($tag, '<mark style="background-color: yellow;">' . ucfirst($tag) . '</mark>', $body);
        }

        return view('cpars.review', compact('cpar', 'sections', 'body'));
      }
      else {
        return view('errors.404');
      }
    }
    else {
      return view('errors.404');
    }
  }

  public function saveReview(Cpar $cpar) {
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'tried to review the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

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

    $cparReviewed              = CparReviewed::where('cpar_id', $cpar->id)->first();
    $cparReviewed->status      = 1;
    $cparReviewed->reviewed_by = request('user.first_name') . ' ' . request('user.last_name');
    $cparReviewed->save();


    $responsiblePerson = collect(NA::user($cpar->person_responsible));

    if (request()->hasFile('attachments')) {
      $files = request()->file('attachments');
      foreach ($files as $key => $file) {
        $sequence                = Attachment::where('cpar_id', $cpar->id)->select('id')->get()->count() + 1;
        $path                    = Storage::putFile('attachments', new File($file));
        $attachment              = new Attachment();
        $attachment->cpar_id     = $cpar->id;
        $attachment->file_name   = 'attachment_' . $sequence;
        $attachment->file_path   = 'storage/' . $path;
        $attachment->section     = 'save-review';
        $attachment->uploaded_by = $responsiblePerson['first_name'] . ' ' . $responsiblePerson['last_name'];
        $attachment->save();
      }
    }

    Mail::to(EqmsUser::mainDocumentController()->email)->send(new CparFinalized($cpar->id));

    session()->flash('attention', ['body' => '<strong>To finalize the CPAR that has been reviewed</strong>, the Document Controller needs to add its <strong>CPAR Number</strong>', 'color' => 'info']);
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'successfully reviewed the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    return redirect()->route('cpars.index');
  }

  public function verify(Cpar $cpar) {
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'visited verifying page for the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    if ($cpar->chief == request('user.id')) {
      if ($cpar->cparClosed->status <> 1 && $cpar->date_confirmed == NULL) {
        $sections = Section::with('documents')->get();

        $cparReviewed            = CparReviewed::find($cpar->id);
        $cparReviewed->on_review = 1;
        $cparReviewed->save();

        $document = Document::find($cpar->document_id);
        $body     = str_replace('&nbsp;', '', $document->body);
        $tags     = explode(',', $cpar->tags);

        foreach ($tags as $tag) {
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
    Mail::to(EqmsUser::where('role', 'Admin')->get()[0]->email)->send(new CparFinalized($cpar->id));

    session()->flash('attention', ['body' => 'CPAR has been sent to QMR for review. You will receive an email when the review process has been finalized. Thank you.', 'color' => 'info']);
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'successfully finalized the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    return redirect('cpars');
  }

  public function saveAsDraft(Cpar $cpar) {
    $user = collect(NA::user($cpar->person_responsible));
    Make::log(
        'save a draft of the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

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

  public function createCparNumber($id) {
    $updateCpar = Cpar::find($id);
    $user       = collect(NA::user($updateCpar->person_responsible));
    Make::log(
        'tried to create CPAR number for the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    $this->validate(request(), [
        'cpar_number' => 'required|unique:cpars,cpar_number'
    ]);

    $updateCpar->cpar_number = request('cpar_number');
    $updateCpar->save();

    $cparReviewed           = CparReviewed::find($id);
    $cparReviewed->status   = 1;
    $cparReviewed->notified = 1;
    $cparReviewed->save();

    $cparClosed = CparClosed::find($id);
    //close reviewed cpar
    $cparClosed->status    = 1;
    $cparClosed->notified  = 1;
    $cparClosed->closed_by = request('user.first_name') . ' ' . request('user.last_name');
    $cparClosed->remarks   = "";
    $cparClosed->save();

    //notify department head
    Mail::to($this->getEmail($updateCpar->chief))->send(new ReviewedCpar($id));

    session()->flash('notify', ['message' => 'CPAR number successfully added.', 'type' => 'success']);
    $user = collect(NA::user($updateCpar->person_responsible));
    Make::log(
        'successfully created CPAR number for the CPAR of ' . $user['first_name'] . ' ' . $user['last_name'],
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
        $_SERVER['REMOTE_ADDR']
    );

    return back();
  }
}
