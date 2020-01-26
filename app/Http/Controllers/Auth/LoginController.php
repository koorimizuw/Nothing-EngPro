<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $info = $request->only('name', 'password');
        $validator = Validator::make($info, [
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) { return response()->json('Login error.', \Illuminate\Http\Response::HTTP_UNAUTHORIZED); }

        //Verify from request
        $creds = $request->only('password');
        $creds['name'] = $info['name'];
        if (!auth()->attempt($creds)) 
        {
            return response()->json('Login failed.', \Illuminate\Http\Response::HTTP_UNAUTHORIZED);
        }

        //Check bearer token
        $user = auth()->user();
        $oauth_access_token = DB::table('oauth_access_tokens')->where('user_id', $user->id)->get()->toArray();
        $token = $user->createToken('user')->accessToken;
        //$user->tokens()->delete();
        return [
            //'user' => $user,
            'token' => $token
        ];
    }
}
