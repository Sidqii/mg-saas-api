<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Authentication\RegisController;
use App\Http\Controllers\Project\BoardController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\TaskController;
use App\Http\Controllers\Workspace\WorkspaceController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::post('/regis', [RegisController::class, 'register']);

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::find($id);

    if (! $user) {
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    if ($user->hasVerifiedEmail()) {
        return response()->json([
            'message' => 'Email already verified'
        ]);
    }

    if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        return response()->json([
            'message' => 'Invalid hash'
        ], 403);
    }

    $user->markEmailAsVerified();

    return response()->json([
        'message' => 'Email verified successfully'
    ]);
})->middleware(['signed'])->name('verification.verify');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('workspaces', WorkspaceController::class);

    Route::scopeBindings()->group(function () {
        Route::apiResource('workspaces.projects', ProjectController::class);

        Route::apiResource('projects.boards', BoardController::class);

        Route::apiResource('boards.tasks', TaskController::class);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
