<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccessRequest;
use App\NA;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AccessRequestController extends Controller
{
    public function __construct() {
        $this->middleware('na.authenticate', ['except' => ['store']]);
    }

    public function index() {
        $accessRequests = AccessRequest::where('status', 'Pending')->orWhere('status', 'Granted')->paginate(5);
        return view ('accessrequests.index', compact('accessRequests'));
    }

    public function store(Request $request){
        Validator::make($request->all(), ['purpose' => 'required|max:4000'])->validate();

        $accessRequest = new AccessRequest();
        $accessRequest->user_id = $request->user_id;
        $accessRequest->user_name = $request->user_name;
        $accessRequest->purpose = $request->purpose;
        $accessRequest->save();
        return redirect('pending');
    }

    public function destroy($id) {
        $accessRequest = AccessRequest::find($id);
        $accessRequest->fill(['status' => 'Denied'])->save();
        $accessRequest->delete();
        session()->flash('notify', ['message' => 'Request has been denied.', 'type' => 'success']);
        return redirect()->route('access-requests.index');
    }

    public function grant(Request $request, $id) {
        $accessRequest = AccessRequest::find($id);

        if (NA::grantTemporaryAccess($accessRequest->user_id, $request->duration)) {
            $accessRequest->fill(['status' => 'Granted'])->save();
            session()->flash('notify', ['message' => 'Access has been granted.', 'type' => 'success']);
        } else {
            session()->flash('notify', ['message' => 'Something went wrong!.', 'type' => 'danger']);
        }
        return redirect()->route('access-requests.index');
    }

    public function revoke(Request $request, $id) {
        $accessRequest = AccessRequest::find($id);

        if (NA::revokeTemporaryAccess($accessRequest->user_id)) {
            $accessRequest->fill(['status' => 'Revoked'])->save();
            $accessRequest->delete();
            session()->flash('notify', ['message' => 'Access has been revoked.', 'type' => 'success']);
        } else {
            session()->flash('notify', ['message' => 'Something went wrong!.', 'type' => 'danger']);
        }
        return redirect()->route('access-requests.index');
    }

}