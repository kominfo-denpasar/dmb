<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LogtoService;

class SSOController extends Controller
{
	protected LogtoService $logto;

	public function __construct(LogtoService $logto)
	{
		$this->logto = $logto;
	}

	public function login()
	{
		return redirect($this->logto->loginUrl());
	}

	public function callback(Request $request)
	{
		$response = $this->logto->handleCallback();
		// dd(session()->all());

		if ($response['success'] === false) {
			return redirect('/login')->with('error', 'Autentikasi gagal. Silakan coba lagi.');
		}

		$email = $response['data']->email ?? null;

		if (!$email) {
			return redirect('/login')->with('error', 'Akun ini tidak memiliki email pada SSO.');
		}

		$user = User::where('email', $email)->first();

		if (!$user) {
			return redirect('/login')->with('error', 'Akun Anda belum terdaftar pada Aplikasi ini. Silakan registrasi manual.');
		}

		Auth::login($user);
		return redirect('/admin/home')->with('success', 'Login berhasil. Selamat datang, ' . $user->name . '!');
	}

	public function me()
	{
		if (! $this->logto->isAuthenticated()) {
			return redirect('/sign-in');
		}

		return response()->json($this->logto->getUserInfo());
	}


}
