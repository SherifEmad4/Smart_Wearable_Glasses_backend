<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Correct use of the Laravel Request class
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user and generate a token
        if ($token = auth()->attempt($request->only('email', 'password'))) {
            // Check the user's role after authentication
            $user = auth()->user();
            $user->is_active = true ;
            $user->save();
            $response = [
                'message' => 'Login successful',
                'user' => $user,
                'token' => $this->createNewToken($token), // Return the JWT token
            ];

            if ($user->role === 'admin') {
                $response['dashboard'] = route('admin-home'); // Optional: Provide admin-specific data
            }

            return response()->json($response, 200);
        }

        // If authentication fails, return an error response
        return response()->json(['error' => 'Invalid email or password'], 401);
    }
    public function createNewToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60,
            'user'=>auth()->user()
        ]);
    }
    public function logout(){
        $user = Auth::user();
        // Update 'is_active' to false
        $user->is_active = false;
        $user->save();
        auth()->logout();
        return response()->json([
            'message'=>'User Logged Out'
        ]);
    }
}
