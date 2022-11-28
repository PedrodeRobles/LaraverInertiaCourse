<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Notes/Index', [
            'notes' => Note::latest()
                ->where('excerpt', 'LIKE', "%$request->q%")
                ->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Notes/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'excerpt' => 'required',
            'content' => 'required',
        ]);

        $note = Note::create($request->all());


        return redirect()->route('notes.show', $note->id)->with('status', 'Nota creada');
    }

    public function show(Note $note)
    {
        return Inertia::render('Notes/Show', compact('note'));
    }

    public function edit(Note $note)
    {
        return Inertia::render('Notes/Edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'excerpt' => 'required',
            'content' => 'required',
        ]);

        $note->update($request->all());


        return redirect()->route('notes.index')->with('status', 'Nota editada');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')->with('status', 'Nota eliminada');
    }
}
