<?php

declare(strict_types=1);


namespace Proxy\OAuth\Interfaces;

interface HttpClientInterface
{
    public function get(string $url, array $body = [], array $headers = []);

    public function post(string $url, array $body = [], array $headers = []);

    public function process(string $method, string $url, array $body = [], array $headers = []);
}