<?php

declare(strict_types=1);


namespace Proxy\OAuth\Helpers;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class GuzzleHttpClient implements HttpClientInterface
{

    public function get(string $url, array $body = [], array $headers = [], array $options = [])
    {
        return $this->process('GET', $url, $body, $headers, $options);
    }

    public function post(string $url, array $body = [], array $headers = [], array $options = [])
    {
        return $this->process('POST', $url, $body, $headers, $options);
    }

    public function process(string $method, string $url, array $body = [], array $headers = [], array $options = [])
    {
        $client = new Client();

        try {
            return $client->request(
                $method,
                $url,
                [
                    'form_params' => $body,
                    'headers' => $headers,
                    $options
                ],
            )->getBody()->getContents();
        } catch (ClientException $e) {
            var_dump(json_decode((string)$e->getResponse()->getBody()));
            throw new Exception(
                json_decode((string)$e->getResponse()->getBody())->message,
                $e->getCode()
            );
        }
    }
}