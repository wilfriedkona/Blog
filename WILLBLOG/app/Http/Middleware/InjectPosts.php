<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Commentaire;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InjectPosts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Récupérer les posts de l'utilisateur connecté
            $posts = Commentaire::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();

            // Partager les posts avec toutes les vues
            view()->share('posts', $posts);
        }

        return $next($request);
    }

    public function commentpost()
{
    // Récupérer les posts avec leurs commentaires et les utilisateurs associés
    $posts = Commentaire::with(['comments.user'])
                        ->orderBy('created_at', 'desc')
                        ->get();

    return view('connect', compact('posts'));
}

// public function postuser()
// {
//     // Récupérer les posts avec les informations de l'utilisateur et les commentaires
//     $posts = Commentaire::with(['user', 'comments.user'])
//                         ->orderBy('created_at', 'desc')
//                         ->get();

//     return view('connect', compact('posts'));
// }
}