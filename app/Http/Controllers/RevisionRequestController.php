<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RevisionRequest;
use App\RevisionRequestSectionB;
use App\RevisionRequestSectionC;
use App\RevisionRequestSectionD;
use App\Section;
use App\Document;
use App\Attachment;
use App\NA;
use App\Mail\NewRevisionRequest;
use App\Mail\DeniedRevisionRequest;
use App\Mail\OnProcessRevisionRequest;
use App\Mail\ApprovedRevisionRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use App\Http\Requests\RevisionRequestForm;

class RevisionRequestController extends Controller
{
    public function __construct() {
        $this->middleware('na.authenticate');
    }

    public function index() {
        $revisionRequests = RevisionRequest::with('reference_document', 'attachments', 'section_b')->orderBy('created_at', 'desc')->paginate(5);
        return view('revisionrequests.index', compact('revisionRequests'));
    }

    public function create() {
        $documentTitles = Document::select('id', 'title')->get();
        if($referenceDocumentId = request('reference_document')) {
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
        return view('revisionrequests.show', compact('revisionRequest'));
    }

    public function update(Request $request, $id) {
        $revisionRequest = RevisionRequest::with('section_b', 'section_c', 'section_d')->find($id);

        if ( ! $revisionRequest->section_b) {
            RevisionRequestSectionB::create([
                'revision_request_id' => $id,
                'user_id' => $request->user['id'],
                'user_name' => $request->user['first_name'] . ' ' . $request->user['last_name'],
                'recommendation_status' => $request->recommendation_status,
                'recommendation_reason' => $request->recommendation_reason
            ]);

            if ($request->recommendation_status == 'For Disapproval') {
                $revisionRequest->fill(['status' => 'Denied'])->save();
                Mail::to(NA::user($revisionRequest->user_id)['email'])
                    ->send(new DeniedRevisionRequest(RevisionRequest::with('reference_document', 'section_b')->find($id)));
            } else {
                $revisionRequest->fill(['status' => 'Processing'])->save();
                Mail::to(NA::user($revisionRequest->user_id)['email'])
                    ->send(new OnProcessRevisionRequest(RevisionRequest::with('reference_document', 'section_b')->find($id)));
            }

        } else if ( ! $revisionRequest->section_c) {
            RevisionRequestSectionC::create([
                'revision_request_id' => $id,
                'user_id' => $request->user['id'],
                'user_name' => $request->user['first_name'] . ' ' . $request->user['last_name'],
                'ceo_remarks' => $request->ceo_remarks,
                'approved' => $request->approved
            ]);

            if ($files = $request->file('attachments')) {
                foreach($files as $key => $file) {
                    $path = $file->store('attachments', 'public');

                    Attachment::create([
                        'revision_request_id' => $id,
                        'file_name' => 'attachment_' . ($key + 1),
                        'file_path' => 'storage/' . $path,
                        'section' => 'revision-request-c',
                        'uploaded_by' => $revisionRequest->user['first_name'] . ' ' . $revisionRequest->user['last_name']
                    ]);
                }
            }

            if ($request->approved) {
                $revisionRequest->fill(['status' => 'Approved'])->save();
                Mail::to(NA::user($revisionRequest->user_id)['email'])
                    ->send(new ApprovedRevisionRequest(RevisionRequest::with('reference_document', 'section_b', 'section_c')->find($id)));
            } else {
                $revisionRequest->fill(['status' => 'Denied'])->save();
                Mail::to(NA::user($revisionRequest->user_id)['email'])
                    ->send(new DeniedRevisionRequest(RevisionRequest::with('reference_document', 'section_b', 'section_c')->find($id)));
            }

        } else if ( ! $revisionRequest->section_d) {
            RevisionRequestSectionD::create([
                'revision_request_id' => $id,
                'user_id' => $request->user['id'],
                'user_name' => $request->user['first_name'] . ' ' . $request->user['last_name'],
                'action_taken' => implode(',', $request->action_taken),
                'others' => $request->others,
            ]);

        } else {
            $revisionRequest->fill(['revision_request_number' => $request->revision_request_number])->save();
            return redirect()->route('revision-requests.index');

        }
        return redirect()->route('revision-requests.show', $revisionRequest->id);
    }

    public function destroy($id) {
        //
    }

    public function printRevisionRequest($id) {
        $revisionRequest = RevisionRequest::with('reference_document')->find($id);
        return view('revisionrequests.print', compact('revisionRequest'));
    }

}
