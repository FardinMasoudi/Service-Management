<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Services\VerificationCodeDrivers\VerificationCodeService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request, VerificationCodeService $codeService)
    {
        DB::transaction(function () use ($request, $codeService) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => $request->password,
            ]);

            $codeService->sendVerificationCode($user, config('services.verificationCodeDriver'));
        });

        return response()->json(200);
    }
}
