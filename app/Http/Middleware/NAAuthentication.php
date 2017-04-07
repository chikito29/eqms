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
        session(['intended' => $request->url()]);
        if ($request->session()->has('na_access_token')) {
            $client = new Client();
            try {
                $userDetailsResponse = $client->get(env('NA_URL') . '/api/user', [
            		'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json'],
                    'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            	]);
            } catch (RequestException $e) {

                // Check if the API Authentication Fails
                if ($e->getResponse()->getStatusCode() == 401) {
                    return redirect('login');
                } else if ($e->getResponse()->getStatusCode() == 403) {
                    $response = json_decode((string) $e->getResponse()->getBody(), true);
                    return response(view('errors.unauthorize', ['user' => $response['user']]));
                }
            }
            $request['user'] = json_decode((string) $userDetailsResponse->getBody(), true);
            return $next($request);
        } else {
            return redirect('login');
        }
    }
}
