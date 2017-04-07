<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\RevisionRequest;
use App\Attachment;
use App\Mail\NewRevisionRequest;
use Illuminate\Support\Facades\Mail;

class RevisionRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'proposed_revision' => 'required',
            'revision_reason' => 'required|max:600'
        ];
    }

    public function persist()
    {
        $revisionRequest = RevisionRequest::create([
            'user_id' => $this->user['id'],
            'user_name' => $this->user['first_name'] . ' ' . $this->user['last_name'],
            'reference_document_id' => $this->reference_document_id,
            'reference_document_tags' => $this->reference_document_tags,
            'proposed_revision' => $this->proposed_revision,
            'revision_reason' => $this->revision_reason
        ]);

        if ($files = $this->file('attachments')) {
            foreach($files as $key => $file) {
                $path = $file->store('attachments', 'public');

                Attachment::create([
                    'revision_request_id' => $revisionRequest->id,
                    'file_name' => 'attachment_' . ($key + 1),
                    'file_path' => 'storage/' . $path,
                    'section' => 'revision-request-a',
                    'uploaded_by' => $this->user['first_name'] . ' ' . $this->user['last_name']
                ]);
            }
        }

        Mail::to('qmr@newsim.ph')->send(new NewRevisionRequest(RevisionRequest::with('reference_document')->find($revisionRequest->id)));
        session()->flash('notify', ['message' => 'Sending revision request successful.', 'type' => 'success']);
    }
}
