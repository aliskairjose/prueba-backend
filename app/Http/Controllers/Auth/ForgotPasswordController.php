<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected function sendResetLinkResponse($response)
    {
        if (request()->header('Content-Type') == 'application/json') {
            return response()->json([
              'isSuccess' => true,
              'message'   => 'Recovery email sent.'
            ], 200);
        }
        return back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if (request()->header('Content-Type') == 'application/json') {
            return response()->json([
              'isSuccess' => false,
              'error'     => 'Oops something went wrong.'
            ], 500);
        }

        return back()->withErrors(
          ['email' => trans($response)]
        );
    }

}
