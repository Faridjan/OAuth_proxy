<?php

declare(strict_types=1);


namespace Proxy\OAuth\Handlers;


use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class LogoutHandler
{

    private ConverterInterface $converter;
    private HttpClientInterface $httpClient;
    private ConfigStoreInterface $configStore;
    private array $authData;
    private AccessHandler $accessHandler;

    public function __construct(
        ConverterInterface $converter,
        HttpClientInterface $httpClient,
        ConfigStoreInterface $configStore,
        array $authData,
        AccessHandler $accessHandler
    ) {
        $this->converter = $converter;
        $this->httpClient = $httpClient;
        $this->configStore = $configStore;
        $this->authData = $authData;
        $this->accessHandler = $accessHandler;
    }

    public function getAuthData(): array
    {
        return $this->authData;
    }

    public function setAuthData(array $authData): void
    {
        $this->authData = $authData;
    }

    public function logout(): void
    {
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $checkUrl = trim($this->configStore->get('OAUTH_LOGOUT_URL'), '/');

        $url = $baseUrl . '/' . $checkUrl;

        $decryptedToken = json_decode($this->converter->fromFrontendToJWT($this->authData), true);

        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $decryptedToken['access_token']
        ];

        $response = $this->httpClient->process('POST', $url, [], $headers);

        if ($response->getStatusCode() === 400) {
            $response = $this->accessHandler->refresh($decryptedToken['refresh_token']);
        }

        $data = json_decode((string) $response->getBody(), true);


        $headers2 = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $data['access_token']
        ];

        $this->httpClient->process('GET', $url, [], $headers2);

    }
}