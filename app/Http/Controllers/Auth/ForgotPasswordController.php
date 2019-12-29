<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordRecover;
use App\Mail\RecoveryPassword;
// use App\Transformers\Json;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

// use Illuminate\Support\Facades\Password;
// use Illuminate\Foundation\Auth\ResetsPasswords;


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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getResetToken(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'El correo no pudo ser enviado'
            ]);
        }

        try {
            Mail::to($user['email'])->send(new RecoveryPassword);
        } catch (\Exception $e) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'No se pudo enviar el correo a ' . $user['email'],
            ]);
        }
        // $token = $this->broker()->createToken($user);

        return response()->json([
            'isSuccess' => true,
            // 'token' => $token,
            'messagge' => 'El mensaje ha sido enviado con exito a ' . $user['email']
        ]);
    }
}
