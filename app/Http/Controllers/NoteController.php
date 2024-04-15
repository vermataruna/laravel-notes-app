<?php

namespace App\Http\Controllers;

use App\Jobs\SendNoteCreatedEmail;
use App\Mail\NoteCreated;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::query()
            ->where('user_id', request()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('note.index', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('note.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'note' => ['required', 'string']
        ]);

        $data['user_id'] = $user->id;
        $note = Note::create($data);

        SendNoteCreatedEmail::dispatch($user, $note);

        return to_route('note.show', $note)->with('message', 'Note was create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return view('note.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return view('note.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $data = $request->validate([
            'note' => ['required', 'string']
        ]);

        $note->update($data);

        return to_route('note.show', $note)->with('message', 'Note was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return to_route('note.index')->with('message', 'Note was deleted');
    }
}
