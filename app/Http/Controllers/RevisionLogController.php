<?php

namespace App\Http\Controllers;

use App\Document;
use App\RevisionLog;
use Illuminate\Http\Request;

class RevisionLogController extends Controller {
    public function __construct(){
        $this->middleware('na.authenticate');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $logs = RevisionLog::paginate(10);
        $documentTitle = Document::select('id', 'title')->get();

        return view('revision-logs.index', ['logs' => $logs, 'documentTitle' => $documentTitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store() {
        $this->validate(request(), [
            'date' => 'required',
            'document-id' => 'required',
            'description' => 'required',
            'revision-number' => 'required',
            'approved-by' => 'required'
        ]);

        $document = Document::select('id', 'title')->where('id', request('document-id'))->take(1)->get();

        RevisionLog::unguard();
        RevisionLog::create([
            'date' => request('date'),
            'document_id' => $document[0]->id,
            'manual_reference' => $document[0]->title,
            'description' => request('description'),
            'revision_number' => request('revision-number'),
            'approved_by' => request('approved-by'),
            'encoded_by' => request('user.first_name') . ' ' . request('user.last_name')
        ]);
        RevisionLog::reguard();

        return redirect()->route('revision-logs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisionLog $revision_log) {
        $revision_log->delete();

        return redirect()->route('revision-logs.index');
    }
}
