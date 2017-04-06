<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class NA extends Model
{
    public static function positions() {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/positions', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json'], 'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                //
            } else if ($e->getResponse()->getStatusCode() == 403) {
                //
            }
        }
        return json_decode((string) $response->getBody(), true);
    }

    public static function branches() {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/branches', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json'], 'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                //
            } else if ($e->getResponse()->getStatusCode() == 403) {
                //
            }
        }
        return json_decode((string) $response->getBody(), true);
    }

    public static function departments() {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/departments', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json'], 'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                //
            } else if ($e->getResponse()->getStatusCode() == 403) {
                //
            }
        }
        return json_decode((string) $response->getBody(), true);
    }

    public static function users() {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/users', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json'], 'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                //
            } else if ($e->getResponse()->getStatusCode() == 403) {
                //
            }
        }
        return json_decode((string) $response->getBody(), true);
    }

    public static function user($id) {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/users/' . $id, [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json'], 'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                //
            } else if ($e->getResponse()->getStatusCode() == 403) {
                //
            }
        }
        return json_decode((string) $response->getBody(), true);
    }

}
