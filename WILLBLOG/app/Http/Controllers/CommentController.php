<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller

{
    //modif Maj et destroy commentaire


public function edit(Comment $comment)
{
    if ($comment->user_id !== auth()->id()) {
        return redirect()->route('connect')->with('error', "Vous n'êtes pas autorisé à modifier ce commentaire.");
    }
    return view('editcommentaire', compact('comment'));
}


public function update(Request $request, Comment $comment)
{
    if ($comment->user_id !== auth()->id()) {
        return redirect()->route('connect')->with('error', "Vous n'êtes pas autorisé à modifier ce commentaire.");
    }

    $request->validate([
        'commentaire' => 'required|string',
    ]);

    $comment->update([
        'commentaire' => $request->commentaire,
    ]);

    return redirect()->route('connect')->with('success', 'Commentaire mis à jour avec succès !');
}


public function destroy(Comment $comment)
{
    if ($comment->user_id !== auth()->id()) {
        return redirect()->route('connect')->with('error', "Vous n'êtes pas autorisé à supprimer ce commentaire.");
    }

    $comment->delete();

    return redirect()->route('connect')->with('success', 'Commentaire supprimé avec succès !');
}
}
