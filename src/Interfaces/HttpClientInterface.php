<?php

declare(strict_types=1);

namespace Proxy\OAuth\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function get(string $url, array $body = [], array $headers = [], array $options = []): ResponseInterface;

    public function post(string $url, array $body = [], array $headers = [], array $options = []): ResponseInterface;

    public function process(
        string $method,
        string $url,
        array $body = [],
        array $headers = [],
        array $options = []
    ): ResponseInterface;
}
