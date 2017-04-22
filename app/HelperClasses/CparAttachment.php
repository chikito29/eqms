<?php

namespace App\HelperClasses;

use App\Attachment;

class CparAttachment {
	public function delete(Attachment $attachment) {
		unlink($attachment->file_path);
		$attachment->delete();
	}
}
