<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\Controller;
use App\Traits\TokenValidation; // إضافة التريت هنا
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Correct use of the Laravel Request class
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon; // تأكد من استيراد Carbon

class LoginController extends Controller
{
    use AuthenticatesUsers, TokenValidation; // استخدام التريت هنا

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

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return redirect()->guest(route('login'));
    }
    /**
     * Handle the login request and return the access token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            $user->is_active = true;
            $user->save();

            // Return response with token and user data
            $response = [
                'user_id' => $user->id ,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,

            ];

            // Add additional information for admin users if needed
            if ($user->role === 'admin') {
                $response['dashboard'] = route('admin-home'); // Optional: Provide admin-specific data
            }

            return response()->json($response, 200);
        }

        // If authentication fails, return an error response
        return response()->json(['error' => 'Invalid email or password'], 401);
    }

    /**
     * Get the authenticated user's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        // تحقق من صحة التوكن واسترجع المستخدم
        $user = $this->validateToken();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user; // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        // التحقق من نوع المستخدم
        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Admin Profile',
                'admin' => $user,
            ]);
        }

        return response()->json([
            'message' => 'User Profile',
            'user' => $user,
        ]);
    }

    /**
     * Logout the user and update 'is_active' to false.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // تحقق من التوكن قبل تسجيل الخروج
        $user = $this->validateToken();
        if ($user instanceof \Illuminate\Http\JsonResponse) {
            return $user; // إذا كانت هناك مشكلة بالتوكن، نُعيد الاستجابة
        }

        $user = Auth::user();
        // Update 'is_active' to false
        $user->is_active = false;
        $user->save();
        auth()->logout();

        return response()->json([
            'message' => 'User Logged Out',
        ]);
    }


    /**
     * Create a new token for the authenticated user.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $user = auth()->user();
        $expiresAt = Carbon::now()->addMinutes(auth()->factory()->getTTL());

        return response()->json([
            'access_token' => $token,
            'token_id' => $user->id,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'expires_at' => $expiresAt->toDateTimeString(),
        ]);
    }
}

