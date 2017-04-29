<?php

namespace App\Http\Controllers;

use App\Log;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LogController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser($id) {
        $client = new Client();
        try {
            $response = $client->get(env('NA_URL') . '/api/users/' . $id, [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token')],
                'query'   => ['client_id' => env('NA_CLIENT_ID', 0)]
            ]);
        } catch (RequestException $e) {
        }
        return (string)$response->getBody();
    }

    public function index() {
        $logs = Log::paginate(20);

        return view('logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log $logs
     * @return \Illuminate\Http\Response
     */
    public function show(Logs $logs) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Log $logs
     * @return \Illuminate\Http\Response
     */
    public function edit(Logs $logs) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Log $logs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logs $logs) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Log $logs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logs $logs) {
        //
    }
}
