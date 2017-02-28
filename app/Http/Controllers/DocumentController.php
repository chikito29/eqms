<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Document;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller {

    public function __construct() {
        $this->middleware('na.authenticate');
    }

    public function index() {
        $documents = Document::where('body', 'like', '%' . request('search') . '%')->get();
        $sections = Section::with('documents')->get();
        return view('documents.search', compact('sections', 'documents'));
    }

    public function create() {
        $sections = Section::with('documents')->get();
        return view('documents.create', compact('sections'));
    }

    public function store(Request $request) {
        Validator::make($request->all(), ['section-id' => 'required', 'title' => 'required|max:255', 'body' => 'required'])->validate();
        $document = new Document();
		$document->section_id = request('section-id');
		$document->title = request('title');
		$document->body = request('body');
		$document->created_by = request('user.first_name');
		$document->save();
        session()->flash('notify', ['message' => 'Posting \'' . $document->title . '\' successfull!', 'type' => 'success']);
        return redirect()->route('documents.show', $document->id);
    }

    public function show($id) {
        $document = Document::find($id);
        $sections = Section::with('documents')->get();
        return view('documents.show', compact('sections', 'document'));
    }

    public function edit($id) {
        $document = Document::find($id);
        $sections = Section::with('documents')->get();
        return view('documents.edit', compact('sections', 'document'));
    }

    public function update(Request $request, $id) {
        $request->all();
        Validator::make($request->all(), ['section-id' => 'required', 'title' => 'required|max:255', 'body' => 'required'])->validate();
        $sections = Section::with('documents')->get();
        $document = Document::find($id);
        $document->title = $request->input('title');
        $document->section_id = $request->input('section-id');
        $document->body = $request->input('body');
        $document->updated_by = $request->user['id'];
        $document->save();
        session()->flash('notify', ['message' => $document->title . ' has been updated.', 'type' => 'success']);
        return redirect()->route('documents.show', $document->id);
    }

    public function destroy($id) {
        $document = Document::find($id);
        $document->delete();
        session()->flash('notify', ['message' => $document->title . ' has been removed!', 'type' => 'success']);
        return redirect('home');
    }
}
