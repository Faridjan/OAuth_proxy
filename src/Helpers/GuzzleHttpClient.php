<?php

declare(strict_types=1);


namespace Proxy\OAuth\Helpers;


use GuzzleHttp\Client;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class GuzzleHttpClient implements HttpClientInterface
{

    public function get(string $url, array $body = [], array $headers = [])
    {
        return json_decode($this->process('GET', $url, $body, $headers));
    }

    public function post(string $url, array $body = [], array $headers = [])
    {
        return json_decode($this->process('POST', $url, $body, $headers));
    }

    public function process(string $method, string $url, array $body = [], array $headers = [])
    {
        $client = new Client();

        return $client->request(
            $method,
            $url,
            [
                'form_params' => $body,
                'headers' => $headers
            ],
        )->getBody()->getContents();
    }
}