<?php

declare(strict_types=1);


namespace Proxy\OAuth\Action;

use Proxy\OAuth\Helpers\GuzzleHttpClient;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class AccessAction
{
    private ConverterInterface $converter;
    private HttpClientInterface $httpClient;
    private ConfigStoreInterface $configStore;

    private array $authData;

    public function __construct(
        ConverterInterface $converter,
        ConfigStoreInterface $configStore,
        array $authData,
        HttpClientInterface $httpClient = null
    ) {
        $this->authData = $authData;
        $this->converter = $converter;
        $this->configStore = $configStore;
        $this->httpClient = $httpClient ?? new GuzzleHttpClient();
    }

    public function __invoke(): array
    {
        $authData = $this->getAuthData();
        $decryptedAuthData = json_decode($this->converter->fromFrontendToJWT($authData), true);

        if (!$this->check()) {
            $jwtFromRefresh = (new RefreshAction($this->configStore, $this->httpClient))
                ->refresh($decryptedAuthData['refresh_token']);
            return $this->converter->fromJWTToFrontend($jwtFromRefresh);
        }
        return $authData;
    }

    public function check(): bool
    {
        $authData = $this->getAuthData();
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $checkUrl = trim($this->configStore->get('OAUTH_CHECK_URL'), '/');

        $url = $baseUrl . '/' . $checkUrl;

        $decryptedAuthData = json_decode($this->converter->fromFrontendToJWT($authData), true);

        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $decryptedAuthData['access_token'],
        ];

        $responseClient = $this->httpClient->get($url, [], $headers, ['http_errors' => false]);


        return $responseClient->getStatusCode() === 200;
    }

    public function refresh(string $refreshToken): string
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

    public function getAuthData(): array
    {
        return $this->authData;
    }

    public function setAuthData(array $authData): void
    {
        $this->authData = $authData;
    }


}