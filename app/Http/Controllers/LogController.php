<?php

namespace App\Http\Controllers;

use App\Log;
use App\NA;
use GuzzleHttp\Client;
use App\HelperClasses\Make;
use Illuminate\Http\Request;

class LogController extends Controller {

    public function __construct() {
        $this->middleware('na.authenticate');
    }

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

    public function index(Request $request) {
        $users = NA::users();
        $logs = Log::paginate(20);

        Make::log(
            'visited Logs index',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        if($request->has('search')) {
            $logs = Log::searchLogBy($request->search);
            $logs = $logs->paginate(10);
        } elseif(! $request->has('search')) {
            $this->validate($request, [ 'updated_at' => 'required_unless:created_at,""' ], [ 'updated_at.required_unless' => 'Date range must be complete or empty.' ]);

            $query = Log::query();

            foreach($request->except('user', 'page', 'search-type', 'created_at', 'updated_at') as $key => $value) {
                if($value == null) continue;
                else { $query = Log::filterBy($query, $key, $value); }
            }

            if($request->has('created_at')) {
                $query = Log::filterByDateRange($query, $request->created_at, $request->updated_at);
            }

            $logs = $query->latest()->paginate(10);
        } else {
            $logs = Log::latest()->paginate(10);
        }

        $params = '?';

        foreach($request->except('user', 'page', 'search-type') as $key => $value) {
            if($params == '?') { $params = $params .$key. '=' .$value; }
            else { $params = $params .'&'. $key .'='. $value; }
        }

        $logs->setPath($request->url() . $params);

        return view('logs.index', compact('logs', 'users'));
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
