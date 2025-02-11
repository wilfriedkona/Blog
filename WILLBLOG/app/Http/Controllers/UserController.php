<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Affiche une liste des users.
     */
    public function index()
    {
        $users = User::all();
        return view('admin', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle ressource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Enregistre une ressource nouvellement créée dans le stockage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Password::defaults()],
            'gender' => ['nullable', 'in:homme,femme'],
            'age' => ['nullable', 'integer', 'min:13', 'max:35'],
            'role' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'age' => $request->age,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    /**
     * Affiche la ressource spécifiée.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Affiche le formulaire de modification de la ressource spécifiée.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Met à jour la ressource spécifiée dans le stockage.
     */
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'gender' => 'required|in:homme,femme',
        'age' => 'required|integer|min:13|max:35',
        'role' => 'required|boolean',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'gender' => $request->gender,
        'age' => $request->age,
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès !');
}

    /**
     * Supprime la ressource spécifiée du stockage.
     */
    
     public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès !');
}
}