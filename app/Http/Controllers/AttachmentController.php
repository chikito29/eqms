<?php

namespace App\Http\Controllers;

use App\HelperClasses\CparAttachment;
use App\Attachment;

class AttachmentController extends Controller
{
    public function destroy(Attachment $attachment) {
		$ca = new CparAttachment();
		$ca->delete($attachment);

		session()->flash('notify', ['message' => 'CPAR attachment successfully deleted.', 'type' => 'success']);
		return back();
	}
}
