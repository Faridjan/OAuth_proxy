<?php

declare(strict_types=1);

namespace Proxy\OAuth\Action;

use Proxy\OAuth\Helpers\GuzzleHttpClient;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class LogoutAction
{

    private ConverterInterface $converter;
    private HttpClientInterface $httpClient;
    private ConfigStoreInterface $configStore;
    private array $authData;
    private string $url;

    public function __construct(
        ConverterInterface $converter,
        ConfigStoreInterface $configStore,
        array $authData,
        HttpClientInterface $httpClient = null
    ) {
        $this->converter = $converter;
        $this->configStore = $configStore;
        $this->authData = $authData;
        $this->httpClient = $httpClient ?? new GuzzleHttpClient();

        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $checkUrl = trim($this->configStore->get('OAUTH_LOGOUT_URL'), '/');
        $this->url = $baseUrl . '/' . $checkUrl;
    }

    public function getAuthData(): array
    {
        return $this->authData;
    }

    public function setAuthData(array $authData): void
    {
        $this->authData = $authData;
    }

    public function execute(): bool
    {
        if (!$this->logoutByAuthData()) {
            return $this->logoutByRefreshToken();
        }

        return true;
    }

    private function logoutByAuthData(): bool
    {
        $decryptedToken = json_decode($this->converter->fromFrontendToJWT($this->getAuthData()), true);

        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $decryptedToken['access_token']
        ];

        $response = $this->httpClient->post($this->url, [], $headers, ['http_errors' => false]);

        if ($response->getStatusCode() === 200) {
            return true;
        }

        return false;
    }

    private function logoutByRefreshToken(): bool
    {
        $decryptedToken = json_decode($this->converter->fromFrontendToJWT($this->getAuthData()), true);

        $jwtFromRefresh = (new RefreshAction($this->configStore, $this->httpClient))
            ->refresh($decryptedToken['refresh_token']);
        $jwt = json_decode((string)$jwtFromRefresh, true);

        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $jwt['access_token']
        ];

        $this->httpClient->post($this->url, [], $headers);

        return true;
    }
}
