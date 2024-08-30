<?php
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::prefix('tasks')->group(function(){
        Route::get('/', [TasksController::class, 'index'])->name('tasks-index');
        Route::get('/create', [TasksController::class, 'create'])->name('tasks-create');
        Route::post('/', [TasksController::class, 'store'])->name('tasks-store');
        Route::get('/{id}/edit', [TasksController::class, 'edit'])->where('id','[0-9]+')->name('tasks-edit');
        Route::put('/{id}', [TasksController::class, 'update'])->where('id','[0-9]+')->name('tasks-update');
        Route::put('/{id}/complete', [TasksController::class, 'complete'])->where('id', '[0-9]+')->name('tasks-complete');
        Route::delete('/{id}', [TasksController::class, 'destroy'])->where('id','[0-9]+')->name('tasks-destroy');
    });
});

Route::fallback(function(){
    return "Erro!";
});
