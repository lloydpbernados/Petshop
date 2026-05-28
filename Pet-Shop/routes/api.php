<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PetController;
use App\Http\Controllers\Api\SupplyController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\ActivityController;

Route::prefix('v1')->middleware(['web', 'auth'])->group(function () {

    // ── Pets ─────────────────────────────────────────────
    Route::get('/pets',                   [PetController::class, 'index']);
    Route::post('/pets',                  [PetController::class, 'store']);
    Route::post('/pets/{pet}',            [PetController::class, 'update']);
    Route::put('/pets/{pet}',             [PetController::class, 'update']);
    Route::patch('/pets/{pet}/stock',     [PetController::class, 'adjustStock']);
    Route::post('/pets/{pet}/restock',    [PetController::class, 'restock']);
    Route::delete('/pets/{pet}',          [PetController::class, 'destroy']);

    // ── Supplies ─────────────────────────────────────────
    Route::get('/supplies',                   [SupplyController::class, 'index']);
    Route::post('/supplies',                  [SupplyController::class, 'store']);
    Route::post('/supplies/{supply}',         [SupplyController::class, 'update']);
    Route::put('/supplies/{supply}',          [SupplyController::class, 'update']);
    Route::patch('/supplies/{supply}/stock',  [SupplyController::class, 'adjustStock']);
    Route::post('/supplies/{supply}/restock', [SupplyController::class, 'restock']);
    Route::delete('/supplies/{supply}',       [SupplyController::class, 'destroy']);

    // ── Services ─────────────────────────────────────────
    Route::get('/services',               [ServiceController::class, 'index']);
    Route::post('/services',              [ServiceController::class, 'store']);
    Route::put('/services/{service}',     [ServiceController::class, 'update']);
    Route::delete('/services/{service}',  [ServiceController::class, 'destroy']);

    // ── Orders ───────────────────────────────────────────
    Route::patch('/orders/{number}/status', [OrderController::class, 'updateStatus']);
    Route::get('/orders/export',            [OrderController::class, 'exportCsv']);

    // ── Conversations & Messages ──────────────────────────
    Route::get('/conversations',                          [ConversationController::class, 'index']);
    Route::get('/conversations/{conversation}/messages',  [ConversationController::class, 'messages']);
    Route::post('/conversations/{conversation}/messages', [ConversationController::class, 'sendMessage']);
    Route::delete('/conversations/{conversation}',        [ConversationController::class, 'destroy']);

    // ── Dashboard Activity Feed ───────────────────────────
    Route::get('/activities', [ActivityController::class, 'index']);

});