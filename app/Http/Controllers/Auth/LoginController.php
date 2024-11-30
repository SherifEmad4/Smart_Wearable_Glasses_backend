<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Correct use of the Laravel Request class
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    // Get all input data from the request
    $input = $request->all();

    // Validate the incoming request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to authenticate the user
    if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
        // If login is successful, check the user's role
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin-home'); // Redirect to admin-home
        } else {
            return redirect()->route('home'); // Redirect to home if the user is not an admin
        }
    }

    // If authentication fails, return an error response
    return redirect()->route('login')->with('error', 'Input Proper Email Or Password');
}

}
