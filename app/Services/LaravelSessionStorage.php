<?php
namespace App\Services;

use Illuminate\Session\Store;
use Logto\Sdk\Storage\Storage;
use Logto\Sdk\Storage\StorageKey;

class LaravelSessionStorage implements Storage
{
    public function __construct(protected Store $session) {}

    public function get(StorageKey $key): ?string
    {
        return $this->session->get($key->value);
    }

    public function set(StorageKey $key, ?string $value): void
    {
        $this->session->put($key->value, $value);
    }

    public function delete(StorageKey $key): void
    {
        $this->session->forget($key->value);
    }

    public function clear(): void
    {
        foreach ($this->session->all() as $key => $value) {
            if (str_starts_with($key, 'logto::')) {
                $this->session->forget($key);
            }
        }
    }
}
