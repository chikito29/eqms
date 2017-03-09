<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RevisionRequest;
use App\Section;
use App\Document;
use App\Attachment;

class RevisionRequestController extends Controller
{
    public function __construct() {
        $this->middleware('na.authenticate');
    }

    public function index() {
        $sections = Section::with('documents')->get();
        $revisionRequests = RevisionRequest::with('reference_document')->get();
        return view('revisionrequests.index', compact('sections', 'revisionRequests'));
    }

    public function create() {
        $sections = Section::with('documents')->get();
        $documentTitles = Document::select('id', 'title')->get();
        if($referenceDocumentId = request('reference_document')) {
            $referenceDocument = Document::find($referenceDocumentId);
            return view('revisionrequests.create', compact('sections', 'documentTitles', 'referenceDocument'));
        }
        return view('revisionrequests.create', compact('sections', 'documentTitles'));
    }

    public function store(Request $request) {
        Validator::make($request->all(), ['proposed_revision' => 'required', 'revision_reason' => 'required'])->validate();

        $revisionRequest = new RevisionRequest();
        $revisionRequest->author_id = $request->input('user.id');
        $revisionRequest->author_name = $request->input('user.first_name') . ' ' . $request->input('user.last_name');
        $revisionRequest->reference_document_id = $request->input('reference_document_id');
        $revisionRequest->reference_document_tags = $request->input('reference_document_tags');
        $revisionRequest->proposed_revision = $request->input('proposed_revision');
        $revisionRequest->revision_reason = $request->input('revision_reason');
        $revisionRequest->save();

        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            foreach($files as $file) {
                $path = $file->store('attachments', 'public');
                $attachment = new Attachment();
                $attachment->revision_request_id = $revisionRequest->id;
                $attachment->file_name = 'storage/' . $path;
                $attachment->uploaded_by = $request->input('user.first_name') . ' ' . $request->input('user.last_name');
                $attachment->save();
            }
        }
        return redirect()->route('revision-requests.index');
    }

    public function show($id) {
        $sections = Section::with('documents')->get();
        $revisionRequest = RevisionRequest::with('reference_document')->find($id);
        return view('revisionrequests.show', compact('sections', 'revisionRequest'));
    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {
        $sections = Section::with('documents')->get();
        $revisionRequest = RevisionRequest::find($id);
        $revisionRequest->recommendation_status = $request->input('recommendation_status');
        $revisionRequest->recommendation_reason = $request->input('recommendation_reason');
        $revisionRequest->save();
        return $revisionRequest;
    }

    public function destroy($id) {
        //
    }
}
