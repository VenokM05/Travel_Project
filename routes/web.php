<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::patch('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences');
    
    // User discovery & follow
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/search', [App\Http\Controllers\UserController::class, 'index'])->name('search');
        Route::get('/suggestions', [App\Http\Controllers\UserController::class, 'suggestions'])->name('suggestions');
        Route::get('/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('show');
        Route::post('/{user}/follow', [App\Http\Controllers\UserController::class, 'follow'])->name('follow');
        Route::get('/{user}/followers', [App\Http\Controllers\UserController::class, 'followers'])->name('followers');
        Route::get('/{user}/following', [App\Http\Controllers\UserController::class, 'following'])->name('following');
    });
    
    // Itineraries
    Route::resource('itineraries', App\Http\Controllers\ItineraryController::class);
    
    // Budgets
    Route::resource('budgets', App\Http\Controllers\BudgetController::class);
    Route::post('/budgets/{budget}/expenses', [App\Http\Controllers\BudgetController::class, 'addExpense'])->name('budgets.expenses.store');
    Route::delete('/budgets/{budget}/expenses/{expenseId}', [App\Http\Controllers\BudgetController::class, 'deleteExpense'])->name('budgets.expenses.destroy');
    
    // To-Do List
    Route::resource('todos', App\Http\Controllers\TodoController::class);
    Route::patch('/todos/{todo}/toggle', [App\Http\Controllers\TodoController::class, 'toggleStatus'])->name('todos.toggle');
    
    // Calendar
    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
    
    // Social Features
    Route::prefix('social')->name('social.')->group(function () {
        Route::get('/wall', [App\Http\Controllers\SocialController::class, 'wall'])->name('wall');
        Route::post('/wall', [App\Http\Controllers\SocialController::class, 'storePost'])->name('post.store');
        Route::post('/posts/{post}/like', [App\Http\Controllers\SocialController::class, 'likePost'])->name('post.like');
        Route::post('/posts/{post}/comment', [App\Http\Controllers\SocialController::class, 'commentPost'])->name('post.comment');
        Route::delete('/posts/{post}', [App\Http\Controllers\SocialController::class, 'deletePost'])->name('post.destroy');
        Route::post('/stories', [App\Http\Controllers\SocialController::class, 'storeStory'])->name('story.store');
        Route::get('/stories', [App\Http\Controllers\SocialController::class, 'stories'])->name('stories');
        Route::get('/reels', [App\Http\Controllers\SocialController::class, 'reels'])->name('reels');
    });
    
    // Memories
    Route::resource('memories', App\Http\Controllers\MemoryController::class);
    
    // Subscription
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/plans', [App\Http\Controllers\SubscriptionController::class, 'plans'])->name('plans');
    });
    
    // File Upload
    Route::post('/upload', [App\Http\Controllers\UploadController::class, 'store'])->name('upload.store');
    Route::delete('/upload/{file}', [App\Http\Controllers\UploadController::class, 'destroy'])->name('upload.destroy');
    
    // AJAX Photo Upload (for memories)
    Route::post('/upload/photo', [App\Http\Controllers\UploadController::class, 'uploadPhoto'])->name('upload.photo');
    Route::delete('/upload/photo', [App\Http\Controllers\UploadController::class, 'deletePhoto'])->name('upload.photo.delete');
    
    // Settings
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
});

require __DIR__.'/auth.php';
