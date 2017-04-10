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
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token')],
                'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {}
        return json_decode((string) $response->getBody(), true);
    }

    public static function branches() {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/branches', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token')],
                'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {}
        return json_decode((string) $response->getBody(), true);
    }

    public static function departments() {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/departments', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token')],
                'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {}
        return json_decode((string) $response->getBody(), true);
    }

    public static function users() {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/users' , [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token')],
                'query' => [
                    'client_id' => env('NA_CLIENT_ID', 0),
                ]
            ]);
        }catch (RequestException $e) {}
        return json_decode((string) $response->getBody());
    }

    public static function user($id) {
        $client = new Client();
        try{
            $response = $client->get(env('NA_URL') . '/api/users/' . $id, [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token')],
                'query' => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        }catch (RequestException $e) {}
        return json_decode((string) $response->getBody(), true);
    }

    // Duration is the number of HOURS the user is allowed to access eQMS
    public static function grantTemporaryAccess($id, $duration) {
        $client = new Client();
        try {
            $response = $client->get(env('NA_URL') . '/api/temporary-access/grant', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token')],
                'query' => [
                    'client_id' => env('NA_CLIENT_ID', 0),
                    'user_id' => $id,
                    'hour' => $duration
                ]
            ]);
        } catch (RequestException $e) {
            return false;
        }
        return true;
    }

    public static function revokeTemporaryAccess($id) {
        $client = new Client();
        try {
            $response = $client->get(env('NA_URL') . '/api/temporary-access/revoke', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token')],
                'query' => [
                    'client_id' => env('NA_CLIENT_ID', 0),
                    'user_id' => $id
                ]
            ]);
        } catch (RequestException $e) {
            return false;
        }
        return true;
    }

}
