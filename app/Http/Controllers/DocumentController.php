<?php

namespace App\Http\Controllers;

use App\HelperClasses\Make;
use Illuminate\Http\Request;
use App\Section;
use App\Document;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller {

    public function __construct() {
        $this->middleware('na.authenticate');
    }

    public function index() {
        Make::log(
            'searched for a document using keywords "' .request('search'). '"',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );
        $documents = Document::where('body', 'like', '%' . request('search') . '%')->paginate(5);

        return view('documents.search', compact('documents'));
    }

    public function create() {
        Make::log(
            'visited document creation page',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $sections = Section::all();

        return view('documents.create', compact('sections'));
    }

    public function store(Request $request) {
        Make::log(
            'tried to create a document',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        Validator::make($request->all(), ['section-id' => 'required', 'title' => 'required|max:255', 'body' => 'required'])->validate();
        $document             = new Document();
        $document->section_id = request('section-id');
        $document->title      = request('title');
        $document->body       = request('body');
        $document->created_by = request('user.first_name');
        $document->save();

        session()->flash('notify', ['message' => 'Posting \'' . $document->title . '\' successfull!', 'type' => 'success']);
        Make::log(
            'successfully created a document with title ' . $document->title. ' under section ' . Section::find($document->section_id)->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return redirect()->route('documents.show', $document->id);
    }

    public function show($id) {
        $document = Document::find($id);

        Make::log(
            'viewed document with title ' . $document->title. ' under section ' . Section::find($document->section_id)->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        if (request('search')) {
            $body = str_ireplace(request('search'), '<mark style="background-color: yellow;">' . ucfirst(request('search')) . '</mark>', $document->body);
        } else {
            $body = $document->body;
        }

        return view('documents.show', compact('document', 'body'));
    }

    public function edit($id) {
        $document = Document::find($id);
        $sections = Section::all();

        Make::log(
            'visited viewing of document with title ' . $document->title. ' under section ' . Section::find($document->section_id)->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return view('documents.edit', compact('document', 'sections'));
    }

    public function update(Request $request, $id) {
        $document             = Document::find($id);

        Make::log(
            'tried to edit document with title ' . $document->title. ' under section ' . Section::find($document->section_id)->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        Validator::make($request->all(), ['section-id' => 'required', 'title' => 'required|max:255', 'body' => 'required'])->validate();
        $document->title      = $request->input('title');
        $document->section_id = $request->input('section-id');
        $document->body       = $request->input('body');
        $document->updated_by = $request->user['id'];
        $document->save();

        session()->flash('notify', ['message' => $document->title . ' has been updated.', 'type' => 'success']);
        Make::log(
            'successfully edited document with title ' . $document->title. 'under section ' . Section::find($document->section_id)->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return redirect()->route('documents.show', $document->id);
    }

    public function destroy($id) {
        $document = Document::find($id);

        Make::log(
            'deleted document with title ' .$document->title. ' under section ' . Section::find($document->section_id)->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $document->delete();
        session()->flash('notify', ['message' => $document->title . ' has been removed!', 'type' => 'success']);

        return redirect('home');
    }
}
