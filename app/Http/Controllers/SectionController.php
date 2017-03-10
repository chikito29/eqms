<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;

class SectionController extends Controller
{
    public function __construct() {
        $this->middleware('na.authenticate');
    }

    public function index()
    {
        return view('sections.index');
    }

    public function store(Request $request)
    {
        $section = new Section();
        $section->name = $request->input('name');
        $section->created_by = $request->input('user.first_name') . ' ' . $request->input('user.last_name');
        $section->save();
        session()->flash('notify', ['message' => 'Adding \'' . $section->name . '\' successfull!', 'type' => 'success']);
        return redirect()->route('sections.index');
    }

    public function edit(Section $section)
    {
        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $section = Section::find($id);
        $section->name = $request->input('name');
        $section->save();
        return redirect()->route('sections.index');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        session()->flash('notify', ['message' => $section->name . ' has been removed!', 'type' => 'success']);
        return redirect()->route('sections.index');
    }
}
