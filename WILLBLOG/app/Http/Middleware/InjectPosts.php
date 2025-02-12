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
            // Vérifier si la route actuelle est 'mespostes'
            if ($request->routeIs('mespostes')) {
                // Récupérer les posts de l'utilisateur connecté
                $posts = Commentaire::where('user_id', auth()->id())
                                    ->orderBy('created_at', 'desc')
                                    ->get();
    
                // Partager les posts uniquement pour la vue 'mespostes'
                view()->share('mesposts', $posts);
            }

             // Partager les posts de tous les utilisateurs sur la page 'connect'
        if ($request->routeIs('connect')) {
            $posts = Commentaire::with(['user', 'comments.user'])
                                   ->orderBy('created_at', 'desc')
                                   ->get();

            view()->share('posts', $posts);
           }
        }
    

        return $next($request);
    }

   
}