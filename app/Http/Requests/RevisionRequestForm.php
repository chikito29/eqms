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
            'revision_reason' => 'required|max:600',
            'reference_document_tags' => 'required',
            'attachments' => 'required_if:proposed_revision,"<p><br></p>"'
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

		if (request()->hasFile('attachments')) {
			$files = request()->file('attachments');
			foreach ($files as $key => $file) {
				$sequence = Attachment::where('revision_request_id', $revisionRequest->id)->select('id')->get()->count() + 1;
				$path                            = $file->store('attachments', 'public');
				$attachment                      = new Attachment();
				$attachment->revision_request_id = $revisionRequest->id;
				$attachment->file_name           = 'attachment_' . $sequence;
				$attachment->file_path           = 'storage/' . $path;
				$attachment->section             = 'revision-request-a';
				$attachment->uploaded_by         = $revisionRequest->user['first_name'] . ' ' . $revisionRequest->user['last_name'];
				$attachment->save();
			}
		}

        Mail::to(\App\EqmsUser::adminEmail())->send(new NewRevisionRequest(RevisionRequest::with('reference_document')->find($revisionRequest->id)));
        session()->flash('notify', ['message' => 'Sending revision request successful.', 'type' => 'success']);
    }
}
