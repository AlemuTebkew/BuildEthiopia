<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\ApiMessage;
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
        // if (!$request->hasValidSignature()) {
        //     return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        // }

        //  return $request->route('id');
       return $user= Admin::find(1);
        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendError('Already Verified','');

        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->sendResponse('Email has been verified','');

        //  $user=Admin::findOrFail(request('id'));

        //   if (! $user->hasVerifiedEmail()) {

        //      $user->markEmailAsVerified();
        //      event(new Verified(request()->user()));

        //      return request()->wantsJson() ? response()->json() :
        //                                     redirect(url(env('FRONTEND_URL')).'/dashboard?verified=1');
        // }

        // return request()->wantsJson() ? response()->json() :
        //             redirect(url(env('FRONTEND_URL')).'/dashboard?verified=1');

    }

    public function resend(Request $request){
      //  $user=null;

        $request->user()->sendEmailVerificationNotification();

        return $this->sendResponse('Verfication link sent','');
    }
}
