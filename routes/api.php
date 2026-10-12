<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Auth Endpoints
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('api.password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('api.password.reset');

// Email Verification link (called from the email notification)
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

// Authenticated Endpoints (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    // Email verification resend
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Routes requiring email verification & specific roles
    Route::middleware('verified')->group(function () {

        // Admin Only Routes
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            Route::get('/dashboard', function (Request $request) {
                return response()->json([
                    'status' => true,
                    'message' => 'Welcome Admin!',
                    'data' => [
                        'role' => $request->user()->role,
                        'scope' => 'admin-access',
                    ],
                ]);
            });
        });

        // Moderator Only Routes
        Route::middleware('role:moderator')->prefix('moderator')->group(function () {
            Route::get('/dashboard', function (Request $request) {
                return response()->json([
                    'status' => true,
                    'message' => 'Welcome Moderator!',
                    'data' => [
                        'role' => $request->user()->role,
                        'scope' => 'moderator-access',
                    ],
                ]);
            });
        });

        // Admin & Moderator Shared Routes
        Route::middleware('role:admin,moderator')->prefix('staff')->group(function () {
            Route::get('/overview', function (Request $request) {
                return response()->json([
                    'status' => true,
                    'message' => 'Welcome Staff (Admin or Moderator)!',
                    'data' => [
                        'role' => $request->user()->role,
                        'scope' => 'staff-access',
                    ],
                ]);
            });
        });

        // Standard User Routes
        Route::middleware('role:user')->prefix('user')->group(function () {
            Route::get('/dashboard', function (Request $request) {
                return response()->json([
                    'status' => true,
                    'message' => 'Welcome User!',
                    'data' => [
                        'role' => $request->user()->role,
                        'scope' => 'user-access',
                    ],
                ]);
            });
        });
    });
});
