<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NAController extends Controller
{
    public function login() {
        $query = http_build_query([
    		'client_id' => env('NA_CLIENT_ID', 0),
    		'redirect_uri' => env('NA_CLIENT_REDIRECT'),
    		'response_type' => env('NA_CLIENT_RESPONSE_TYPE'),
    		'scope' => ''
    	]);
    	return redirect(env('NA_URL') . '/oauth/authorize?' . $query);
    }

    public function callback(Request $request) {
        $http = new Client();
    	$tokenResponse = $http->post(env('NA_URL') . '/oauth/token', [
    		'form_params' => [
    			'grant_type' => 'authorization_code',
    			'client_id' => env('NA_CLIENT_ID', 0),
    			'client_secret' => env('NA_CLIENT_SECRET'),
    			'redirect_uri' => env('NA_CLIENT_REDIRECT'),
    			'code' => $request['code']
    		]
    	]);

    	$accessToken = json_decode((string) $tokenResponse->getBody(), true);
        session(['na_access_token' => $accessToken['access_token']]);
        return redirect(session()->pull('intended'));
    }
}
