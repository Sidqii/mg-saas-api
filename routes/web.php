<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

// Route::get('/email/verify{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return response()->json([
//         'message' => 'Email verified successfully'
//     ], 200);
// })->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::get('/', function () {
    return view('welcome');
});
