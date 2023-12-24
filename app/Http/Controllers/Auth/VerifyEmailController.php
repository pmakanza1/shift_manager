<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // dd($request->user());
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        $staffCreated = Staff::where('email', $request->user()->email)->exists();

        $lastStaffId = Staff::all()->last()->staff_id;

        if (!$staffCreated) {
            Staff::create([
                'staff_id' => $lastStaffId + 1,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'is_active' => 1,
                'user_id' => $request->user()->id
            ]);
        }

        return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
    }
}
