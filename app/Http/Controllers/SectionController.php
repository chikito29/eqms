<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HelperClasses\Make;
use App\Section;

class SectionController extends Controller {
    public function __construct() {
        $this->middleware('na.authenticate');
    }

    public function index() {
        Make::log(
            'visited section  index',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $sections = Section::all();

        return view('sections.index', compact('sections'));
    }

    public function store(Request $request) {
        Make::log(
            'tried to add a document section',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $this->validate(request(), [
            'name' => 'required'
        ]);

        $section             = new Section();
        $section->name       = $request->input('name');
        $section->created_by = $request->input('user.first_name') . ' ' . $request->input('user.last_name');
        $section->save();

        session()->flash('notify', ['message' => 'Adding \'' . $section->name . '\' successfull!', 'type' => 'success']);
        Make::log(
            'successfully added a document section',
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return redirect()->route('sections.index');
    }

    public function edit(Section $section) {
        Make::log(
            'visited editing page of document section ' . $section->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, $id) {
        $section       = Section::find($id);
        $old_section_name = $section->name;

        Make::log(
            'tried to edit document section name ' . $section->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        $this->validate(request(), [
            'name' => 'required'
        ]);

        $section->name = $request->input('name');
        $section->save();

        Make::log(
            'successfully edited document section name ' . $old_section_name. ' to ' . $section->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return redirect()->route('sections.index');
    }

    public function destroy(Section $section) {
        $section->delete();
        session()->flash('notify', ['message' => $section->name . ' has been removed!', 'type' => 'success']);
        Make::log(
            'successfully deleted document section name ' . $section->name,
            $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $_SERVER['REMOTE_ADDR']
        );

        return redirect()->route('sections.index');
    }
}
