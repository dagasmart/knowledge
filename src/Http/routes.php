<?php

use Illuminate\Support\Facades\Route;
use DagaSmart\Knowledge\Http\Controllers\KnowledgeCategoryController;
use DagaSmart\Knowledge\Http\Controllers\KnowledgeController;
use DagaSmart\Knowledge\Http\Controllers\KnowledgeSceneController;

/*
|--------------------------------------------------------------------------
| Knowledge Routes
|--------------------------------------------------------------------------
*/

Route::prefix('knowledge')->group(function () {
    Route::resource('items', KnowledgeController::class);
    Route::resource('categories', KnowledgeCategoryController::class);
    Route::resource('scenes', KnowledgeSceneController::class);
});
