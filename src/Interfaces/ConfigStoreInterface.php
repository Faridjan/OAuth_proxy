<?php

declare(strict_types=1);

namespace Proxy\OAuth\Interfaces;

interface ConfigStoreInterface
{
    public function __construct(string $path);

    public function load();

    public function get(string $configName);
}
