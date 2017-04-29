<?php

namespace App\Http\Controllers;

use App\HelperClasses\Make;
use Illuminate\Http\Request;
use App\RevisionRequest;
use App\RevisionRequestSectionB;
use App\RevisionRequestSectionC;
use App\RevisionRequestSectionD;
use App\Document;
use App\Attachment;
use App\NA;
use App\Mail\NewRevisionRequest;
use App\Mail\DeniedRevisionRequest;
use App\Mail\OnProcessRevisionRequest;
use App\Mail\ApprovedRevisionRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RevisionRequestForm;

class RevisionRequestController extends Controller {
    public function __construct() {
        $this->middleware('na.authenticate');
    }

    public function index() {
        Make::log(
            'visited Revision Requests index',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $revisionRequests = RevisionRequest::with('reference_document', 'attachments', 'section_b')->orderBy('created_at', 'desc')->paginate(5);

        return view('revisionrequests.index', compact('revisionRequests'));
    }

    public function create() {
        Make::log(
            'visited Revision Request creation page',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $documentTitles = Document::select('id', 'title')->get();
        if ($referenceDocumentId = request('reference_document')) {
            $referenceDocument = Document::find($referenceDocumentId);

            return view('revisionrequests.create', compact('documentTitles', 'referenceDocument'));
        }

        return view('revisionrequests.create', compact('documentTitles'));
    }

    public function store(RevisionRequestForm $revisionRequestForm) {
        $revisionRequestForm->persist();

        return redirect()->route('revision-requests.index');
    }

    public function show($id) {
        $revisionRequest = RevisionRequest::with('reference_document', 'attachments', 'section_b', 'section_c', 'section_d')->find($id);

        $user = collect(NA::user($revisionRequest->user_id));
        if($revisionRequest->is_appeal != 1) {
            Make::log(
                'visited a Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                $_SERVER['REMOTE_ADDR']
            );
        } else {
            Make::log(
                'visited an appeal of ' . $user['first_name'] .' '. $user['last_name'],
                $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                $_SERVER['REMOTE_ADDR']
            );
        }

        return view('revisionrequests.show', compact('revisionRequest'));
    }

    public function update(Request $request, $id) {
        $revisionRequest = RevisionRequest::with('section_b', 'section_c', 'section_d')->find($id);

        if (!$revisionRequest->section_b) {
            $user = collect(NA::user($revisionRequest->user_id));
            if($revisionRequest->is_appeal != 1) {
                Make::log(
                    'tried to add a recommendation to the Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                    $_SERVER['REMOTE_ADDR']
                );
            } else {
                Make::log(
                    'tried to add a recommendation to the appeal of ' . $user['first_name'] .' '. $user['last_name'],
                    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                    $_SERVER['REMOTE_ADDR']
                );
            }

            $this->validate(request(), [
                'recommendation_reason' => 'required'
            ]);

            RevisionRequestSectionB::create([
                'revision_request_id'   => $id,
                'user_id'               => $request->user['id'],
                'user_name'             => $request->user['first_name'] . ' ' . $request->user['last_name'],
                'recommendation_status' => $request->recommendation_status,
                'recommendation_reason' => $request->recommendation_reason
            ]);

            if ($request->recommendation_status == 'For Disapproval') {
                $revisionRequest->fill(['status' => 'Denied'])->save();
                Mail::to(NA::user($revisionRequest->user_id)->email)
                    ->send(new DeniedRevisionRequest(RevisionRequest::with('reference_document', 'section_b')->find($id)));

                $user = collect(NA::user($revisionRequest->user_id));
                if($revisionRequest->is_appeal != 1) {
                    Make::log(
                        'successfully denied a Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                        $_SERVER['REMOTE_ADDR']
                    );
                } else {
                    Make::log(
                        'successfully denied an appeal of ' . $user['first_name'] .' '. $user['last_name'],
                        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                        $_SERVER['REMOTE_ADDR']
                    );
                }
            }
            else {
                $revisionRequest->fill(['status' => 'Processing'])->save();
                Mail::to(NA::user($revisionRequest->user_id)->email)
                    ->send(new OnProcessRevisionRequest(RevisionRequest::with('reference_document', 'section_b')->find($id)));

                $user = collect(NA::user($revisionRequest->user_id));
                if($revisionRequest->is_appeal != 1) {
                    Make::log(
                        'successfully placed a Revision Request of ' . $user['first_name'] .' '. $user['last_name'] .' '. 'for approval',
                        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                        $_SERVER['REMOTE_ADDR']
                    );
                } else {
                    Make::log(
                        'successfully placed an appeal of ' . $user['first_name'] .' '. $user['last_name'] .' '. 'for approval',
                        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                        $_SERVER['REMOTE_ADDR']
                    );
                }
            }

        }
        else if (!$revisionRequest->section_c) {
            $this->validate(request(), [
                'attachments' => 'required'
            ]);

            RevisionRequestSectionC::create([
                'revision_request_id' => $id,
                'user_id'             => $request->user['id'],
                'user_name'           => $request->user['first_name'] . ' ' . $request->user['last_name'],
                'ceo_remarks'         => $request->ceo_remarks,
                'approved'            => $request->approved
            ]);

            if (request()->hasFile('attachments')) {
                $files = request()->file('attachments');
                foreach ($files as $key => $file) {
                    $sequence                        = Attachment::where('revision_request_id', $revisionRequest->id)->select('id')->get()->count() + 1;
                    $path                            = Storage::putFile('attachments', new File($file));
                    $attachment                      = new Attachment();
                    $attachment->revision_request_id = $revisionRequest->id;
                    $attachment->file_name           = 'attachment_' . $sequence;
                    $attachment->file_path           = 'storage/' . $path;
                    $attachment->section             = 'revision-request-a';
                    $attachment->uploaded_by         = $revisionRequest->user['first_name'] . ' ' . $revisionRequest->user['last_name'];
                    $attachment->save();
                }
            }

            if ($request->approved) {
                $revisionRequest->fill(['status' => 'Approved'])->save();
                Mail::to(NA::user($revisionRequest->user_id)->email)
                    ->send(new ApprovedRevisionRequest(RevisionRequest::with('reference_document', 'section_b', 'section_c')->find($id)));

                $user = collect(NA::user($revisionRequest->user_id));
                if($revisionRequest->is_appeal != 1) {
                    Make::log(
                        'successfully approved a Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                        $_SERVER['REMOTE_ADDR']
                    );
                } else {
                    Make::log(
                        'successfully approved an appeal of ' . $user['first_name'] .' '. $user['last_name'],
                        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                        $_SERVER['REMOTE_ADDR']
                    );
                }
            }
            else {
                $revisionRequest->fill(['status' => 'Denied'])->save();
                Mail::to(NA::user($revisionRequest->user_id)->email)
                    ->send(new DeniedRevisionRequest(RevisionRequest::with('reference_document', 'section_b', 'section_c')->find($id)));

                $user = collect(NA::user($revisionRequest->user_id));
                if($revisionRequest->is_appeal != 1) {
                    Make::log(
                        'successfully denied a Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                        $_SERVER['REMOTE_ADDR']
                    );
                } else {
                    Make::log(
                        'successfully denied an appeal of ' . $user['first_name'] .' '. $user['last_name'],
                        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                        $_SERVER['REMOTE_ADDR']
                    );
                }
            }

        }
        else if (!$revisionRequest->section_d) {
            $this->validate(request(), [
                'others' => 'required_without:action_taken'
            ]);

            RevisionRequestSectionD::create([
                'revision_request_id' => $id,
                'user_id'             => $request->user['id'],
                'user_name'           => $request->user['first_name'] . ' ' . $request->user['last_name'],
                'action_taken'        => implode(',', $request->action_taken),
                'others'              => $request->others,
            ]);

            $user = collect(NA::user($revisionRequest->user_id));
            if($revisionRequest->is_appeal != 1) {
                Make::log(
                    'successfully completed "Section D" of Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                    $_SERVER['REMOTE_ADDR']
                );
            } else {
                Make::log(
                    'successfully completed "Section D" of the appeal of ' . $user['first_name'] .' '. $user['last_name'],
                    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                    $_SERVER['REMOTE_ADDR']
                );
            }
        }
        else {
            $user = collect(NA::user($revisionRequest->user_id));
            if($revisionRequest->is_appeal) {
                Make::log(
                    'tried to add Revision Request Number to the Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                    $_SERVER['REMOTE_ADDR']
                );
            } else {
                Make::log(
                    'tried to add Revision Request Number to the appeal of ' . $user['first_name'] .' '. $user['last_name'],
                    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                    $_SERVER['REMOTE_ADDR']
                );
            }

            $this->validate(request(), [
                'revision_request_number' => 'required'
            ]);

            $revisionRequest->fill(['revision_request_number' => $request->revision_request_number])->save();

            $user = collect(NA::user($revisionRequest->user_id));
            if($revisionRequest->is_appeal != 1) {
                Make::log(
                    'successfully added Revision Request Number to the Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                    $_SERVER['REMOTE_ADDR']
                );
            } else {
                Make::log(
                    'successfully added Revision Request Number to the appeal of ' . $user['first_name'] .' '. $user['last_name'],
                    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                    $_SERVER['REMOTE_ADDR']
                );
            }

            return redirect()->route('revision-requests.index');

        }

        return redirect()->route('revision-requests.show', $revisionRequest->id);
    }

    public function destroy($id) {
        //
    }

    public function printRevisionRequest($id) {
        $revisionRequest = RevisionRequest::with('reference_document')->find($id);

        $user = collect(NA::user($revisionRequest->user_id));
        if($revisionRequest->is_appeal != 1) {
            Make::log(
                'printed a copy of Revision Request of ' . $user['first_name'] .' '. $user['last_name'],
                $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                $_SERVER['REMOTE_ADDR']
            );
        } else {
            Make::log(
                'printed a copy of appeal of ' . $user['first_name'] .' '. $user['last_name'],
                $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                $_SERVER['REMOTE_ADDR']
            );
        }

        return view('revisionrequests.print', compact('revisionRequest'));
    }

    public function appeal(RevisionRequest $revisionRequest) {
        Make::log(
            'made an appeal to his/her denied Revision Request',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $referenceDocument = Document::find($revisionRequest->reference_document_id);

        return view('revisionrequests.appeal', compact('revisionRequest', 'referenceDocument'));
    }

    public function storeAppeal($id) {
        Make::log(
            'tried to submit appeal to his/her denied Revision Request',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $this->validate(request(), [
            'reference_document_tags' => 'required',
            'revision_reason'         => 'required',
            'attachments'             => 'required_without:uses_old_attachment',
            'proposed_revision'       => 'required_without:uses_old_attachment|required_if:attachments,""'
        ]);

        $revisionRequest = RevisionRequest::create([
            'user_id'                 => request('user.id'),
            'user_name'               => request('user.first_name') . ' ' . request('user.last_name'),
            'reference_document_id'   => request('reference_document_id'),
            'revision_request_id'     => $id,
            'reference_document_tags' => request('reference_document_tags'),
            'proposed_revision'       => request('proposed_revision'),
            'revision_reason'         => request('revision_reason'),
            'is_appeal'               => 1,
            'status'                  => 'Appeal'
        ]);

        $old_revision_request             = RevisionRequest::find(request('reference_document_id'));
        $old_revision_request->has_appeal = 1;
        $old_revision_request->save();

        $uses_old_attachment = request('uses_old_attachment');
        if ($uses_old_attachment <> NULL) {
            $revisionRequest->uses_old_attachment = 1;
            $revisionRequest->save();
        }

        if (request()->hasFile('attachments')) {
            $files = request()->file('attachments');
            foreach ($files as $key => $file) {
                $sequence                        = Attachment::where('revision_request_id', $revisionRequest->id)->select('id')->get()->count() + 1;
                $path                            = Storage::putFile('attachments', new File($file));
                $attachment                      = new Attachment();
                $attachment->revision_request_id = $revisionRequest->id;
                $attachment->file_name           = 'appeal_attachment_' . $sequence;
                $attachment->file_path           = 'storage/' . $path;
                $attachment->section             = 'appeal';
                $attachment->uploaded_by         = request('user.first_name') . ' ' . request('user.last_name');
                $attachment->save();
            }
        }

        Mail::to(\App\EqmsUser::adminEmail())->send(new NewRevisionRequest(RevisionRequest::with('reference_document')->find($revisionRequest->id)));
        session()->flash('notify', ['message' => 'Sending revision request appeal successful.', 'type' => 'success']);

        Make::log(
            'successfully submitted his/her appeal to his/her denied Revision Request',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return redirect('revision-requests');
    }
}
