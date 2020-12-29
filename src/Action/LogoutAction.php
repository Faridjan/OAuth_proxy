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
    private string $url;

    public function __construct(
        ConverterInterface $converter,
        ConfigStoreInterface $configStore,
        HttpClientInterface $httpClient = null
    ) {
        $this->converter = $converter;
        $this->configStore = $configStore;
        $this->httpClient = $httpClient ?? new GuzzleHttpClient();

        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $checkUrl = trim($this->configStore->get('OAUTH_LOGOUT_URL'), '/');
        $this->url = $baseUrl . '/' . $checkUrl;
    }

    public function execute($authData): bool
    {
        $decryptedAuthData = json_decode($this->converter->fromFrontendToJWT($authData), true);

        if (!$this->logoutByAuthData($decryptedAuthData['access_token'])) {
            return $this->logoutByRefreshToken($decryptedAuthData['refresh_token']);
        }

        return true;
    }

    private function logoutByAuthData(string $accessToken): bool
    {
        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $accessToken
        ];

        $response = $this->httpClient->post($this->url, [], $headers, ['http_errors' => false]);

        if ($response->getStatusCode() === 200) {
            return true;
        }

        return false;
    }

    private function logoutByRefreshToken(string $refreshToken): bool
    {
        $jwtFromRefresh = (new RefreshAction($this->configStore, $this->httpClient))
            ->refresh($refreshToken);
        $jwt = json_decode((string)$jwtFromRefresh, true);

        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $jwt['access_token']
        ];

        $this->httpClient->post($this->url, [], $headers);

        return true;
    }
}
