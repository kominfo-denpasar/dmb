<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \Spatie\Activitylog\facades\Activity;
use App\Services\LogtoService;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
	protected LogtoService $ssoService;

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
	public function __construct(LogtoService $logto)
	{
		$this->middleware('guest')->except('logout');
		$this->middleware('auth')->only('logout');
		$this->ssoService = $logto;
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

	//override method logout
	public function logout(Request $request) {
		// dd(session()->all());

		// Jika menggunakan SSO, redirect ke URL logout SSO
		$logoutUrl = $this->ssoService->signOut();

		// cata aktivitas
		$user = auth()->user();
		activity()
			->causedBy($user)
			->log('Logout dari sistem');

		$this->guard()->logout();

		// Hapus semua session yang ada
		Session::flush();
		$request->session()->flush();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		
		return Redirect::to($logoutUrl);
	}
}
