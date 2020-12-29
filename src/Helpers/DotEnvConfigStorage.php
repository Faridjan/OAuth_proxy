<?php

declare(strict_types=1);

namespace Proxy\OAuth\Helpers;

use Dotenv\Dotenv;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;

class DotEnvConfigStorage implements ConfigStoreInterface
{

    private Dotenv $store;

    public function __construct(string $path)
    {
        $this->store = Dotenv::createUnsafeImmutable($path);
    }

    public function load()
    {
        $this->store->load();
    }

    public function get(string $configName): string
    {
        return getenv($configName) ?: '';
    }
}
