<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Show the email verification notice page.
     */
    public function notice()
    {
        return view('admin.verify-email');
    }

    /**
     * Handle the email verification link.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('admin.dashboard')->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     */
    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'تم إرسال رابط التحقق بنجاح!');
    }
}
