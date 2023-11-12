<?php
use Illuminate\Support\Facades\Route;
use Aguva\Ussd\Controllers\OnlineController;

Route::any(config('ussd.online_endpoint'), [OnlineController::class, 'processPayload'])->name('online.processPayload');