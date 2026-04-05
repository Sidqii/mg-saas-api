<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisRequest;

class RegisController extends Controller
{
    /**
     * Input user data into database
     */
    public function register(RegisRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Registration successfully',
            'data' => [
                'user_id' => $user->id,
                'user_email' => $user->email
            ]
        ], 201);
    }
}
