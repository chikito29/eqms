<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NAController extends Controller
{
    public function login() {
        if(session()->has('na_access_token')) {
            return redirect('home');
        }
        $query = http_build_query([
    		'client_id' => 21,
    		'redirect_uri' => 'http://eqms.newsimapps.dev/callback',
    		'response_type' => 'code',
    		'scope' => ''
    	]);
    	return redirect('http://na.dlbajana.xyz/oauth/authorize?' . $query);
    }

    public function callback(Request $request) {
        $http = new Client();
    	$tokenResponse = $http->post('http://na.dlbajana.xyz/oauth/token', [
    		'form_params' => [
    			'grant_type' => 'authorization_code',
    			'client_id' => 21,
    			'client_secret' => 'mT4opoI2VueilZw1V22ifDvSH0c0SXn3U68fg1mS',
    			'redirect_uri' => 'http://eqms.newsimapps.dev/callback',
    			'code' => $request['code']
    		]
    	]);

    	$accessToken = json_decode((string) $tokenResponse->getBody(), true);
        session(['na_access_token' => $accessToken['access_token']]);

    	$userDetailsResponse = $http->get('http://na.dlbajana.xyz/api/user', [
    		'headers' => ['Authorization' => 'Bearer ' . $accessToken['access_token'], 'Accept' => 'application/json']
    	]);

    	// return $userDetailsResponse->getBody();
        return redirect('home');
    }
}
