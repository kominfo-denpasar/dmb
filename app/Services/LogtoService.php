<?php
namespace App\Services;

use Logto\Sdk\LogtoConfig;
use Logto\Sdk\LogtoClient as Logto;

class LogtoService
{
    protected Logto $logto;

    public function __construct()
    {
        $config = new LogtoConfig(
            config('logto.endpoint'),
            config('logto.app_id'),
            config('logto.app_secret'),
            config('logto.scopes')
            // config('logto.redirect_uri')
        );

        $this->logto = new Logto($config);
    }

    public function loginUrl(): string
    {
        return $this->logto->buildAuthorizationUrl();
    }

    public function handleCallback(string $code): void
    {
        $this->logto->handleRedirectCallback($code);
    }

    public function getUser()
    {
        return $this->logto->getUserInfo();
    }
}
