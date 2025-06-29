<?php
namespace App\Services;

use Illuminate\Http\Request;
use Logto\Sdk\LogtoConfig;
use Logto\Sdk\LogtoClient;
use Logto\Sdk\Constants\UserScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\LaravelSessionStorage;
use Illuminate\Session\Store;

class LogtoService
{
	public LogtoClient $client;

	public function __construct(Store $session)
	{

		// Initialize Logto configuration
		$config = new LogtoConfig(
			endpoint: config('logto.endpoint'),
			appId: config('logto.app_id'),
			appSecret: config('logto.app_secret'),
			// resources: $resources, // Uncomment this line to specify resources
			scopes: [UserScope::email, UserScope::organizations, UserScope::organizationRoles, UserScope::roles], // Update per your needs
		);

		$storage = new LaravelSessionStorage($session);
		$this->client = new LogtoClient($config, $storage);
	}

	public function loginUrl(): string
	{
		// Redirect user ke halaman login Logto
		return $this->client->signIn('http://127.0.0.1:8000/callback');
	}

	public function handleCallback()
	{
		// dd(session()->all());
		// dd($this->client->handleSignInCallback());
		try {
			$this->client->handleSignInCallback(); // Wajib memanggil ini dulu
			return [
				'success' => true,
				'message' => 'Login berhasil',
				'data' => $this->client->fetchUserInfo(),
			];
		} catch (\Throwable $e) {
			// Tangkap response body jika ini exception HTTP
			$message = $e->getMessage();

			// Jika exception memiliki response JSON
			$responseData = null;
			if (method_exists($e, 'getResponse') && $e->getResponse()) {
				$response = $e->getResponse();
				$body = $response->getBody()->getContents();

				try {
					$responseData = json_decode($body, true);
					$message = $responseData['error'] ?? $message;
				} catch (\Throwable $inner) {
					// Biarkan message asli jika tidak bisa decode JSON
				}
			}

			return [
				'success' => false,
				'message' => $message,
				'data' => $responseData,
			];
		}
	}

	public function tryLoginViaSSO(): ?\App\Models\User
	{
		if (! $this->isAuthenticated()) {
			return null;
		}

		$response = $this->handleCallback();

		if (! $response['success']) {
			return null;
		}

		$userData = $response['data'];

		// Cari user berdasarkan email
		return \App\Models\User::where('email', $userData['email'])->first();
	}

	public function validateSessionWithLogtoServer(): bool
	{
		try {
			$user = $this->client->fetchUserInfo();
			return isset($user->sub); // Jika berhasil fetch userInfo, berarti masih valid
		} catch (\Throwable $e) {
			// Gagal fetch berarti token expired / sudah logout dari Logto pusat
			// $this->client->getStorage()->clear(); // Bersihkan session lokal
			return false;
		}
	}

	public function isAuthenticated(): bool
	{
		return $this->client->isAuthenticated();
	}

	public function getUserInfo(): ?array
	{
		return $this->client->fetchUserInfo();
	}

	public function signOut()
	{
		try {
			$logoutUrl = $this->client->signOut(url('/login'));
			return $logoutUrl;
		} catch (\Throwable $e) {
			// Fallback manual redirect URL kalau session logto tidak tersedia
			$logoutUrl = config('logto.endpoint') . '/oidc/logout?client_id=' . config('logto.client_id') . '&post_logout_redirect_uri=' . urlencode(url('/login'));
		}
	}
}
