<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        $user = User::where('email', $loginRequest->email)
            ->first();

        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        $token = Auth::attempt($loginRequest->validated());
        if (!$token) {
            throw new BadRequestException('Email or password is not correct.');
        }

        return (new UserResource($user))->additional([
            'token' => $token
        ]);
    }

    public function register(RegisterRequest $registerRequest)
    {
        DB::beginTransaction();

        try {
            $user = new User();
            $user->name = $registerRequest->name;
            $user->email = $registerRequest->email;
            $user->password = $registerRequest->password;
            $user->save();

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            throw new BadRequestException('Something went wrong.');
        }

        return UserResource::make($user);
    }
}
