<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiMessage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
class EmailVerificationController extends Controller
{
    use ApiMessage;
    public function sendVerificationEmail(Request $request){

        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendError('Already Verified','');

        }

        $request->user()->sendEmailVerificationNotification();

        return $this->sendResponse('Verfication link sent','');
    }

    public function verify(Request $request)
    {

        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendError('Already Verified','');

        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->sendResponse('Email has been verified','');

    }

    public function resend(Request $request){
      //  $user=null;

        $request->user()->sendEmailVerificationNotification();

        return $this->sendResponse('Verfication link sent','');
    }
}
