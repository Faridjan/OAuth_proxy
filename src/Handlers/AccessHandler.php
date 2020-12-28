<?php

declare(strict_types=1);


namespace Proxy\OAuth\Handlers;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class AccessHandler
{
    private ConverterInterface $converter;
    private HttpClientInterface $httpClient;
    private ConfigStoreInterface $configStore;

    private array $token;

    public function __construct(
        ConverterInterface $converter,
        HttpClientInterface $httpClient,
        ConfigStoreInterface $configStore,
        array $token
    ) {
        $this->converter = $converter;
        $this->httpClient = $httpClient;
        $this->configStore = $configStore;
        $this->token = $token;
    }

    public function __invoke(): string
    {
        if (!$this->check()) {
            $responseClient = $this->refresh();
            $this->converter->fromJWTToFrontend($responseClient);
        }
        return $responseClient;
    }

    public function check(): bool
    {
        $token = $this->getToken();
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $checkUrl = trim($this->configStore->get('OAUTH_CHECK_URL'), '/');

        $url = $baseUrl . '/' . $checkUrl;

        $decryptedToken = json_decode($this->converter->fromFrontendToJWT($token), true);

        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $decryptedToken['access_token']
        ];

        $responseClient = $this->httpClient->post($url, [], array($headers, ['http_errors' => false]));

        return $responseClient->getStatus() === 400;
    }

    public function refresh(): string
    {
        $token = $this->token;
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $loginUrl = trim($this->configStore->get('OAUTH_URL'), '/');

        $url = $baseUrl . '/' . $loginUrl;

        $decryptedToken = json_decode($this->converter->fromFrontendToJWT($token), true);

        $body = [
            'grant_type' => $this->configStore->get('OAUTH_REFRESH_GRANT_TYPE'),
            'refresh_token' => $decryptedToken['refresh_token'],
            'client_id' => $this->configStore->get('OAUTH_CLIENT_ID'),
            'client_secret' => $this->configStore->get('OAUTH_CLIENT_SECRET'),
        ];

        try {
            return $this->httpClient->post($url, $body, []);
        } catch (ClientException $e) {
            throw new Exception(
                json_decode($e->getRequest()->getBody()->getContents())->message,
                $e->getCode()
            );
        }
    }

    public function getToken(): array
    {
        return $this->token;
    }

    public function setToken(array $token): void
    {
        $this->token = $token;
    }


}