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

    public function __invoke()
    {
        $token = $this->getToken();
        $decryptedToken = json_decode($this->converter->fromFrontendToJWT($token), true);

        if (!$this->check()) {
            $responseClient = $this->refresh($decryptedToken['refresh_token']);
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
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $decryptedToken['access_token'],
        ];

        $responseClient = $this->httpClient->get($url, [], $headers, ['http_errors' => false]);


        return $responseClient->getStatusCode() === 200;
    }

    public function refresh(string $refreshToken)
    {
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $loginUrl = trim($this->configStore->get('OAUTH_URL'), '/');

        $url = $baseUrl . '/' . $loginUrl;

        $body = [
            'grant_type' => $this->configStore->get('OAUTH_REFRESH_GRANT_TYPE'),
            'refresh_token' => $refreshToken,
            'client_id' => $this->configStore->get('OAUTH_CLIENT_ID'),
            'client_secret' => $this->configStore->get('OAUTH_CLIENT_SECRET'),
        ];

        return $this->httpClient->post($url, $body, [])->getBody()->getContents();
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