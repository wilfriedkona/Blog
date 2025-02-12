<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\CommentController;


//route racine
Route::get('/', function () {
    return view('welcome');
});

// route pour les postes et commentaires
Route::middleware('auth')->group(function () {
    Route::get('/fairposte', [CommentaireController::class, 'create'])->name('fairposte');
    Route::post('/commentaire', [CommentaireController::class, 'store'])->name('commentaire.store');
    Route::get('/mespostes', [CommentaireController::class, 'mespostes'])->name('mespostes');
    Route::get('/commentaire/{commentaire}/edit', [CommentaireController::class, 'edit'])->name('commentaire.edit');
    Route::put('/commentaire/{commentaire}', [CommentaireController::class, 'update'])->name('commentaire.update');
    Route::delete('/commentaire/{commentaire}', [CommentaireController::class, 'destroy'])->name('commentaire.destroy');
    Route::post('/commentaire/{commentaire}/comment', [CommentaireController::class, 'addComment'])->name('commentaire.comment');
});

//route pour crud commentaire de poste modifier et supprimer
Route::middleware('auth')->group(function () {
    Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});

// route pour la vue page mespostes
Route::get('/mespostes', [WelcomeController::class, 'mespostes'])->name('mespostes');

//route pour fairposte
Route::get('/fairposte', [WelcomeController::class, 'fairposte'])->name('fairposte');

//route CRUD admin 
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [UserController::class, 'index'])->name('admin');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

//route pour role1 accede page admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('admin');

//route de deconnexion "ASController"
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

//route pour la page home welcome "WController"
Route::get('/', [WelcomeController::class, 'index']);

//route qui redirige vers connect apres connexion "ASContoller"
Route::get('/connect', function () {
    return view('connect');
})->name('connect');

//route defaut (afffichage)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ça ce sont les routes par defaut pour le dashboard profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
