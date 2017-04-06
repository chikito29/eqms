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
use App\Mail\NewRevisionRequest;
use App\Mail\DeniedRevisionRequest;
use App\Mail\OnProcessRevisionRequest;
use App\Mail\ApprovedRevisionRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;

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

    public function store(Request $request) {
        Validator::make($request->all(), ['proposed_revision' => 'required', 'revision_reason' => 'required|max:600'])->validate();

        $revisionRequest = new RevisionRequest();
        $revisionRequest->user_id = $request->input('user.id');
        $revisionRequest->user_name = $request->input('user.first_name') . ' ' . $request->input('user.last_name');
        $revisionRequest->reference_document_id = $request->input('reference_document_id');
        $revisionRequest->reference_document_tags = $request->input('reference_document_tags');
        $revisionRequest->proposed_revision = $request->input('proposed_revision');
        $revisionRequest->revision_reason = $request->input('revision_reason');
        $revisionRequest->save();

        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            foreach($files as $key => $file) {
                $path = $file->store('attachments', 'public');
                $attachment = new Attachment();
                $attachment->revision_request_id = $revisionRequest->id;
                $attachment->file_name = 'attachment_' . ($key + 1);
                $attachment->file_path = 'storage/' . $path;
                $attachment->section = 'revision-request-a';
                $attachment->uploaded_by = $request->input('user.first_name') . ' ' . $request->input('user.last_name');
                $attachment->save();
            }
        }

        Mail::to('qmr@newsim.ph')->send(new NewRevisionRequest(RevisionRequest::with('reference_document')->find($revisionRequest->id)));

        session()->flash('notify', ['message' => 'Sending revision request successful.', 'type' => 'success']);
        return redirect()->route('revision-requests.index');
    }

    public function show($id) {
        $revisionRequest = RevisionRequest::with('reference_document', 'attachments', 'section_b', 'section_c', 'section_d')->find($id);
        return view('revisionrequests.show', compact('revisionRequest'));
    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {
        $revisionRequest = RevisionRequest::with('section_b', 'section_c', 'section_d')->find($id);
        $http = new Client();
        try{
            $userDetailsResponse = $http->get(env('NA_URL', 'your-user-url') . '/api/users/' . $revisionRequest->user_id, [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json'], 'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {
            // Check if the API Authentication Fails
        }
        $userInfo = json_decode((string) $userDetailsResponse->getBody(), true);

        if ( ! $revisionRequest->section_b) {
            $sectionB = new RevisionRequestSectionB();
            $sectionB->revision_request_id = $id;
            $sectionB->user_id = $request->input('user.id');
            $sectionB->user_name =  $request->input('user.first_name') . ' ' . $request->input('user.last_name');
            $sectionB->recommendation_status = $request->input('recommendation_status');
            $sectionB->recommendation_reason = $request->input('recommendation_reason');
            $sectionB->save();

            if ($request->input('recommendation_status') == 'For Disapproval') {
                $revisionRequest->status = 'Denied';
            } else {
                $revisionRequest->status = 'Processing';
            }
            $revisionRequest->save();

            if ($request->input('recommendation_status') == 'For Disapproval') {
                Mail::to($userInfo['email'])->send(new DeniedRevisionRequest(RevisionRequest::with('reference_document', 'section_b')->find($id)));
            } else {
                Mail::to($userInfo['email'])->send(new OnProcessRevisionRequest(RevisionRequest::with('reference_document', 'section_b')->find($id)));
            }
        } else if ( ! $revisionRequest->section_c) {
            $sectionC = new RevisionRequestSectionC();
            $sectionC->revision_request_id = $id;
            $sectionC->user_id = $request->input('user.id');
            $sectionC->user_name =  $request->input('user.first_name') . ' ' . $request->input('user.last_name');
            $sectionC->ceo_remarks = $request->input('ceo_remarks');
            $sectionC->approved = $request->input('approved');
            $sectionC->save();

            $revisionRequest->status = $request->input('approved') ? 'Approved' : 'Denied';
            $revisionRequest->save();

            if ($request->input('approved')) {
                Mail::to($userInfo['email'])->send(new ApprovedRevisionRequest(RevisionRequest::with('reference_document', 'section_b', 'section_c')->find($id)));
            } else {

            }

            if ($request->hasFile('attachments')) {
                $files = $request->file('attachments');
                foreach($files as $key => $file) {
                    $path = $file->store('attachments', 'public');
                    $attachment = new Attachment();
                    $attachment->revision_request_id = $id;
                    $attachment->file_name = 'signed_revision_request';
                    $attachment->file_path = 'storage/' . $path;
                    $attachment->section = 'revision-request-c';
                    $attachment->uploaded_by = $request->input('user.first_name') . ' ' . $request->input('user.last_name');
                    $attachment->save();
                }
            }

        } else if ( ! $revisionRequest->section_d) {
            $sectionD = new RevisionRequestSectionD();
            $sectionD->revision_request_id = $id;
            $sectionD->user_id = $request->input('user.id');
            $sectionD->user_name =  $request->input('user.first_name') . ' ' . $request->input('user.last_name');
            $sectionD->action_taken = implode(',', $request->input('action_taken'));
            $sectionD->others = $request->input('others');
            $sectionD->save();
            $revisionRequest->status = 'Approved';
            $revisionRequest->save();

        } else {
            $revisionRequest->revision_request_number = $request->input('revision_request_number');
            $revisionRequest->save();
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
