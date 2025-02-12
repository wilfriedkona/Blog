<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;


class CommentaireController extends Controller
{
     
    public function store(Request $request)
{
    $request->validate([
        'url' => 'required|url',
        'titre' => 'required|string|max:255',
        'commentaire' => 'required|string',
    ]);

    $existingPost = Commentaire::where('url', $request->url)->first();

    if ($existingPost) {
        return redirect()->route('connect')->with('post', $existingPost);
    }

    Commentaire::create([
        'url' => $request->url,
        'titre' => $request->titre,
        'commentaire' => $request->commentaire,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('mespostes')->with('success', 'Post créé avec succès !');
}


    public function mespostes()
{
    
    return view('mespostes');
}

    public function update(Request $request, Commentaire $commentaire)
{
 
    if ($commentaire->user_id !== auth()->id()) {
        return redirect()->route('mespostes')->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
    }

    $request->validate([
        'url' => 'required|url',
        'titre' => 'required|string|max:255',
        'commentaire' => 'required|string',
    ]);


    $commentaire->update([
        'url' => $request->url,
        'titre' => $request->titre,
        'commentaire' => $request->commentaire,
    ]);

    return redirect()->route('mespostes')->with('success', 'Post mis à jour avec succès !');
}


    public function destroy(Commentaire $commentaire)
{
    $commentaire->delete();
    return redirect()->route('mespostes')->with('success', 'Post supprimé avec succès !');
}

    public function edit(Commentaire $commentaire)
{

    if ($commentaire->user_id !== auth()->id()) {
        return redirect()->route('mespostes')->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
    }
    return view('editpost', compact('commentaire'));
}


    public function addComment(Request $request, Commentaire $commentaire)
{
 
    $request->validate([
        'commentaire' => 'required|string',
    ]);


    $commentaire->comments()->create([
        'commentaire' => $request->commentaire,
        'user_id' => auth()->id(), 
    ]);

    return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
}


    public function commentpost()
    {   
    
    $posts = Commentaire::with(['comments.user'])
                        ->orderBy('created_at', 'desc')
                        ->get();

    return view('connect', compact('posts'));
    }


    public function connect()
    {
        
        return view('connect');
    }




}


