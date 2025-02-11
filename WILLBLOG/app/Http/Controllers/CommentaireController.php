<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;


class CommentaireController extends Controller
{

    
    
    //methode store pour creer un post
    public function store(Request $request)
{
    $request->validate([
        'url' => 'required|url',
        'titre' => 'required|string|max:255',
        'commentaire' => 'required|string',
    ]);

    // Vérifier si l'URL existe déjà
    $existingPost = Commentaire::where('url', $request->url)->first();

    if ($existingPost) {
        return redirect()->route('connect')->with('post', $existingPost);
    }

    // Créer un nouveau post
    Commentaire::create([
        'url' => $request->url,
        'titre' => $request->titre,
        'commentaire' => $request->commentaire,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('mespostes')->with('success', 'Post créé avec succès !');
}



    // methode pour afficher les postes de l'utilisateur
    public function mespostes()
{
    $posts = Commentaire::where('user_id', auth()->id())->get();
    return view('mespostes', compact('posts'));
}

    // methode pour modifier un poste
    public function update(Request $request, Commentaire $commentaire)
{
    // Vérifier que l'utilisateur connecté est bien l'auteur du post
    if ($commentaire->user_id !== auth()->id()) {
        return redirect()->route('mespostes')->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
    }

    // Validation des champs
    $request->validate([
        'url' => 'required|url',
        'titre' => 'required|string|max:255',
        'commentaire' => 'required|string',
    ]);

    // Mettre à jour le post
    $commentaire->update([
        'url' => $request->url,
        'titre' => $request->titre,
        'commentaire' => $request->commentaire,
    ]);

    return redirect()->route('mespostes')->with('success', 'Post mis à jour avec succès !');
}

    // methode pour supprimer un poste
    public function destroy(Commentaire $commentaire)
{
    $commentaire->delete();
    return redirect()->route('mespostes')->with('success', 'Post supprimé avec succès !');
}

    public function edit(Commentaire $commentaire)
{
    // Vérifier que l'utilisateur connecté est bien l'auteur du post
    if ($commentaire->user_id !== auth()->id()) {
        return redirect()->route('mespostes')->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
    }

    // Afficher le formulaire de modification
    return view('editpost', compact('commentaire'));
}


    public function addComment(Request $request, Commentaire $commentaire)
{
    // Validation du commentaire
    $request->validate([
        'commentaire' => 'required|string',
    ]);

    // Créer un nouveau commentaire associé au post
    $commentaire->comments()->create([
        'commentaire' => $request->commentaire,
        'user_id' => auth()->id(), // Associer le commentaire à l'utilisateur connecté
    ]);

    return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
}

}
