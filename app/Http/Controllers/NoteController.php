<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Str;


class NoteController extends Controller
{
    public function getAllNotes()
    {

        $isLoggedIn = auth()->guard("api")->check();
        if (!$isLoggedIn) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Unauthorized access.",
                ],
                401
            );
        } else {
            $notes = Note::orderBy("created_at", "desc")->get();
            return response()->json(
                [
                    "success" => true,
                    "message" => "Notes retrieved successfully.",
                    "data" => $notes,
                ]
            );
        }
    }

    public function getNoteById($id)
    {
        $note = Note::find($id);
        return response()->json(
            [
                "success" => true,
                "message" => "Note retrieved successfully.",
                "data" => $note,
            ]
        );
    }

    public function createNote(Request $request)
    {
        $request->validate([
            "title" => "required",
            "content" => "required",
        ]);
        $note = new Note();

        $note->id = str::uuid();
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();


        return response()->json(
            [
                "success" => true,
                "message" => "Note created successfully.",
                "data" => $note,
            ]
        );
    }

    public function updateNote(Request $request, $id)
    {
        $note = Note::find($id);
        $note->fill($request->all());
        $note->save();
        return response()->json([
            "success" => true,
            "message" => "Note updated successfully.",
            "data" => $note,
        ]);
    }

    public function deleteNote($id)
    {
        $note = Note::find($id);
        $note->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Note deleted successfully.",
                "data" => $note,
            ]
        );
    }
}
