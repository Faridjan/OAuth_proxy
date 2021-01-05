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
        $checkUrl = trim($this->configStore->get('OAUTH_CHECK_URL'), '/');

        $this->url = $baseUrl . '/' . $checkUrl;
    }

    public function execute(array $authData): array
    {
        $decryptedAuthData = json_decode($this->converter->fromFrontendToJWT($authData), true);
        if (!$this->check($decryptedAuthData['access_token'])) {
            $jwtFromRefresh = (new RefreshAction($this->configStore, $this->httpClient))
                ->refresh($decryptedAuthData['refresh_token']);
            return $this->converter->fromJWTToFrontend($jwtFromRefresh);
        }
        return $authData;
    }

    private function check(string $accessToken): bool
    {
        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $accessToken,
        ];

        $responseClient = $this->httpClient->get($this->url, [], $headers, ['http_errors' => false]);


        return $responseClient->getStatusCode() === 200;
    }
}
