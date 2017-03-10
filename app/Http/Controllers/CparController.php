<?php

namespace App\Http\Controllers;

use App\Cpar;
use App\Document;
use App\DocumentVersion;
use Illuminate\Http\Request;

class CparController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'true';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cpars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $document = Document::find(request('reference'));

        $this->validate(request(), [
            'cpar-number' => 'required',
            'raised-by' => 'required',
            'tags' => 'required',
            'details' => 'required',
            'person-responsible' => 'required',
            'root-cause' => 'required',
        ]);

        $cpar = Cpar::create([
            'cpar_number' => request('cpar-number'),
            'raised_by' => request('raised-by'),
            'department' => request('department'),
            'severity' => request('severity'),
            'document_id' => request('reference'),
            'tags' => request('tags'),
            'source' => request('source'),
            'other_source' => request('other-source'),
            'details' => request('details'),
            'person_reporting' => request('person-reporting'),
            'person_responsible' => request('person-responsible'),
            'root_cause' => request('root-cause'),
            'department_head' => request('department-head')
        ]);

        if (request('attachments')) {
            $files = request('attachments');
            foreach($files as $file) {
                $path = $file->store('attachments', 'public');
                $attachment = new Attachment();
                $attachment->cpar_id = $cpar->id;
                $attachment->file_name = 'storage/' . $path;
                $attachment->uploaded_by = request('user.first_name') . ' ' . request('user.last_name');
                $attachment->save();
            }
        }

        DocumentVersion::create([
            'cpar_id' => $cpar->id,
            'control_number' => "adadasd",
            'document' => $document->body
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cpar  $cpar
     * @return \Illuminate\Http\Response
     */
    public function show(Cpar $cpar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cpar  $cpar
     * @return \Illuminate\Http\Response
     */
    public function edit(Cpar $cpar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cpar  $cpar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cpar $cpar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cpar  $cpar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cpar $cpar)
    {
        //
    }
}
