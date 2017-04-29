<?php

namespace App\HelperClasses;

use App\Log;

class Make {

    public static function log($action, $pageUrl, $ipAddress) {
        $log = new Log();
        $log->action = $action;
        $log->user_id = request('user.id');
        $log->page_url = $pageUrl;
        $log->ip_address = $ipAddress;
        $log->save();
    }
}