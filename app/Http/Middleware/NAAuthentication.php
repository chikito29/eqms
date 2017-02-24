<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class NAAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('na_access_token')) {
            $http = new Client();
            try{
                $userDetailsResponse = $http->get('http://na.dlbajana.xyz/api/user', [
            		'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json']
            	]);
            }catch (RequestException $e) {

                // Check if the API Authentication Fails
                if($e->getResponse()->getStatusCode() == 401) {
                    return redirect('login');
                }
            }
            $request['user'] = json_decode((string) $userDetailsResponse->getBody(), true);
            return $next($request);
        } else {
            return redirect('login');
        }
    }
}
