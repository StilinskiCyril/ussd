<?php
use Illuminate\Support\Facades\Route;
use Stilinski\Ussd\Controllers\OnlineController;

Route::any(config('ussd.online_endpoint'), [OnlineController::class, 'processPayload'])->name('online.processPayload');