<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccessRequest;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AccessRequestController extends Controller
{
    public function __construct() {
        $this->middleware('na.authenticate', ['except' => ['store']]);
    }

    public function index()
    {
        $accessRequests = AccessRequest::paginate(5);
        return view ('accessrequests.index', compact('accessRequests'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'purpose' => 'required|max:4000'
        ])->validate();

        $accessRequest = new AccessRequest();
        $accessRequest->user_id = $request->user_id;
        $accessRequest->user_name = $request->user_name;
        $accessRequest->purpose = $request->purpose;
        $accessRequest->save();
        return redirect('pending');
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $accessRequest = AccessRequest::find($id);

        $client = new Client();
        try {
            $userDetailsResponse = $client->get('http://localhost:8000/api/temporary-access/grant', [
                'headers' => ['Authorization' => 'Bearer ' . session('na_access_token'), 'Accept' => 'application/json'], 'query' => ['client_id' => env('NA_CLIENT_ID', 0), 'user_id' => $accessRequest->user_id, 'hour' => $request->duration]
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
        $accessRequest->status = 'Granted';
        $accessRequest->save();
        return redirect()->route('access-requests.index');
    }

    public function destroy($id) {
        $accessRequest = AccessRequest::find($id);
        $accessRequest->delete();
        return redirect()->route('access-requests.index');
    }

}
