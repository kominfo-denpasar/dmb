<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \Spatie\Activitylog\facades\Activity;

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
    protected $redirectTo = '/admin/home';

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

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'h-captcha-response' => 'required|HCaptcha',
        ]);
    }
    
    // override method yang dipanggil setelah user berhasil login
    protected function authenticated(Request $request, $user) {
        activity()
        ->causedBy($user)
        ->log('login ke sistem');

        return redirect()->intended($this->redirectTo);
    }

    //override  method logout untuk mencatat log aktivitas logout
    public function logout(Request $request) {
        $user = auth()->user();
        
        activity()
        ->causedBy($user)
        ->log('Logout dari sistem');

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
