<?php
use Illuminate\Support\Facades\Route;
use Aguva\Ussd\Controllers\TestController;

Route::get('simulator', [TestController::class, 'simulatorPage'])->name('test.simulatorPage');
Route::post('process-payload', [TestController::class, 'processPayload'])->name('test.processPayload');