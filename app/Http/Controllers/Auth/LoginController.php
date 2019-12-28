<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationFormRequest;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;

        return response()->json(['isSuccess' => true]);

        /*try {
            if (!$token = 'Bearer '.JWTAuth::attempt($credentials)) {
                return response()->json([
                  'isSuccess' => false,
                  'message' => 'Email o Password inválido',
                ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
              'isSuccess' => false,
              'message' => 'No se pudo crear el token'
            ], 500);
        }

        return response()->json([
          'isSuccess' => true,
          'token'   => $token,
        ], 200);*/
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
          'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
              'success' => true,
              'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
              'success' => false,
              'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    /**
     * @param  RegistrationFormRequest  $request
     * @return JsonResponse
     */
    public function register(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
          'success' => true,
          'data'    => $user
        ], 200);
    }
}
