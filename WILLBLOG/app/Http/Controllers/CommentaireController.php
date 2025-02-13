<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;
use Illuminate\Support\Facades\Storage;


class CommentaireController extends Controller
{
     
    public function store(Request $request)
{
    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'titre' => 'required|string|max:255',
        'commentaire' => 'required|string',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public'); 
    }


    Commentaire::create([
        'titre' => $request->titre,
        'commentaire' => $request->commentaire,
        'image' => $imagePath,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('connect')->with('success', 'Post créé avec succès !');
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'titre' => 'required|string|max:255',
        'commentaire' => 'required|string',
    ]);


    $commentaire->update([
        'image' => $request->image,
        'titre' => $request->titre,
        'commentaire' => $request->commentaire,
    ]);

    if ($request->hasFile('image')) {
   
        if ($commentaire->image && Storage::exists('public/' . $commentaire->image)) {
            Storage::delete('public/' . $commentaire->image);
        }

        $imagePath = $request->file('image')->store('posts', 'public');
        $commentaire->image = $imagePath;
    }

    $commentaire->save();

    return redirect()->route('mespostes')->with('success', 'Post mis à jour avec succès !');
}


    public function destroy(Commentaire $commentaire)
{
    if ($commentaire->image) {
        Storage::delete('public/' . $commentaire->image);
    }
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


