<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Monster;

class CommentController extends Controller
{
    public function store(Request $request, $monsterId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->monster_id = $monsterId;
        $comment->content = $request->content;
        $comment->save();

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès!');
    }
}
