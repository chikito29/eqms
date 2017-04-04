<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NAController extends Controller
{
    public function login() {
        $query = http_build_query([
    		'client_id' => env('NA_CLIENT_ID', 0),
    		'redirect_uri' => env('NA_CLIENT_REDIRECT', 'http://localhost/callback'),
    		'response_type' => env('NA_CLIENT_RESPONSE_TYPE', 'code'),
    		'scope' => ''
    	]);
    	return redirect(env('NA_OAUTH_AUTHORIZE_URL', 'authorize-url') . $query);
    }

    public function callback(Request $request) {
        $http = new Client();
    	$tokenResponse = $http->post(env('NA_OAUTH_TOKEN_URL', 'token-url'), [
    		'form_params' => [
    			'grant_type' => 'authorization_code',
    			'client_id' => env('NA_CLIENT_ID', 0),
    			'client_secret' => env('NA_CLIENT_SECRET', 'your-client-secret'),
    			'redirect_uri' => env('NA_CLIENT_REDIRECT', 'http://localhost/callback'),
    			'code' => $request['code']
    		]
    	]);

    	$accessToken = json_decode((string) $tokenResponse->getBody(), true);
        session(['na_access_token' => $accessToken['access_token']]);
        return redirect(session()->pull('intended'));
    }
}
