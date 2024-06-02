<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConduitController;
use App\Http\Controllers\CommentController;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ConduitController::class, 'dashboard'])
    ->name('home');

Route::get('/dashboard', function () {
    $article = Article::all();
    $tags = Tag::all();
    $user = User::all();
    return view('dashboard')
        ->with(['articles' => $article, 'tags' => $tags, 'user' => $user]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('editor')->group(function() {
    Route::get('/', [ConduitController::class, 'editor']);
    Route::get('/{id}', [ConduitController::class, 'edit'])
        ->name('edit')
        ->where('post', '[0-9]+');
    Route::patch('/{id}/update', [ConduitController::class, 'update'])
        ->name('edit.update')
        ->where('post', '[0-9]+');
    Route::post('store', [ConduitController::class, 'store']);
});

Route::prefix('article/{id}')->group(function() {
    Route::get('/', [ConduitController::class, 'article'])
        ->name('article');
    Route::get('/delete', [ConduitController::class, 'delete']);
    Route::delete('/delete', [ConduitController::class, 'delete'])
        ->name('delete');
    Route::post('/store', [CommentController::class, 'store'])
        ->name('comment.store');
});


require __DIR__.'/auth.php';
