<?php

declare(strict_types=1);


namespace Proxy\OAuth\Action;


use Exception;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class LogoutAction
{

    private ConverterInterface $converter;
    private HttpClientInterface $httpClient;
    private ConfigStoreInterface $configStore;
    private array $authData;
    private AccessAction $accessHandler;

    public function __construct(
        ConverterInterface $converter,
        HttpClientInterface $httpClient,
        ConfigStoreInterface $configStore,
        array $authData,
        AccessAction $accessHandler
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

    public function logout(): bool
    {
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $checkUrl = trim($this->configStore->get('OAUTH_LOGOUT_URL'), '/');

        $url = $baseUrl . '/' . $checkUrl;

        $decryptedToken = json_decode($this->converter->fromFrontendToJWT($this->getAuthData()), true);

        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $decryptedToken['access_token']
        ];

        $response = $this->httpClient->post($url, [], $headers, ['http_errors' => false]);

        if ($response->getStatusCode() === 200) {
            return true;
        }

        if ($response->getStatusCode() === 400) {
            $responseBody = $this->accessHandler->refresh($decryptedToken['refresh_token']);
            $data = json_decode((string)$responseBody, true);

            $headers = [
                'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $data['access_token']
            ];

            $response = $this->httpClient->post($url, [], $headers);
        }

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Some Exception text.');
        }

        return true;
    }
}