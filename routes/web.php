<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;


Route::get('/',[UserController::class,'showDataInhome'])->name('home');

Route::get('/dashboard',[UserController::class,'home'])->middleware('auth', 'verified')->name('dashboard');

/*Route::get('admin/dashboard',[UserController::class,'index'])->middleware('auth', 'admin')->name('admin.dashboard');
Route::get('admin/dashboard/post',[UserController::class,'post'])->middleware('auth', 'admin');*/

Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/dashboard',[UserController::class,'index'])->name('admin.dashboard');
    
    Route::get('/dashboard/addPost',[AdminController::class,'addpost'])->name('admin.Addpost');

    Route::post('/dashboard/addPost',[AdminController::class,'createpost'])->name('admin.createpost');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
