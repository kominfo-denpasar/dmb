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

    public function __construct()
    {
        $this->logto = new LogtoService();
    }

    public function login()
    {
        dd('test');
        return redirect($this->logto->loginUrl());
    }

    public function callback(Request $request)
    {
        $code = $request->get('code');
        $this->logto->handleCallback($code);
        $userInfo = $this->logto->getUser();

        // Simpan ke DB atau login ke sistem Laravel
        $user = User::firstOrCreate(
            ['email' => $userInfo['email']],
            ['name' => $userInfo['name']]
        );

        Auth::login($user);
        return redirect('/dashboard');
    }
}
