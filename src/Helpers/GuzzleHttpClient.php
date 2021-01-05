<?php

declare(strict_types=1);

namespace Proxy\OAuth\Helpers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Proxy\OAuth\Interfaces\HttpClientInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient implements HttpClientInterface
{

    public function get(string $url, array $body = [], array $headers = [], array $options = []): ResponseInterface
    {
        return $this->process('GET', $url, $body, $headers, $options);
    }

    public function post(string $url, array $body = [], array $headers = [], array $options = []): ResponseInterface
    {
        return $this->process('POST', $url, $body, $headers, $options);
    }

    public function process(
        string $method,
        string $url,
        array $body = [],
        array $headers = [],
        array $options = []
    ): ResponseInterface {
        $client = new Client();

        try {
            return $client->request(
                $method,
                $url,
                array_merge(
                    [
                        'form_params' => $body,
                        'headers' => $headers,
                    ],
                    $options
                )
            );
        } catch (ClientException $e) {
            throw new Exception(
                json_decode((string)$e->getResponse()->getBody())->message,
                $e->getCode()
            );
        }
    }
}
