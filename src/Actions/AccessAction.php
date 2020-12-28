<?php

declare(strict_types=1);


namespace Proxy\OAuth\Actions;


use Exception;
use GuzzleHttp\Exception\ClientException;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class AccessAction
{
    private ConverterInterface $converter;
    private HttpClientInterface $httpClient;
    private ConfigStoreInterface $configStore;

    private array $token;

    public function __construct(
        ConverterInterface $converter,
        HttpClientInterface $httpClient,
        ConfigStoreInterface $configStore,
        array $token = []
    ) {
        $this->converter = $converter;
        $this->httpClient = $httpClient;
        $this->configStore = $configStore;
        $this->token = $token;
    }


    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    public function check(): void
    {
        $token = $this->token;
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $checkUrl = trim($this->configStore->get('OAUTH_CHECK_URL'), '/');

        $url = $baseUrl . '/' . $checkUrl;

        $decryptedToken = json_decode($this->converter->fromFrontendToJWT($token), true);

        $headers = [
            'Authorization' => $this->configStore->get('OAUTH_TYPE') . ' ' . $decryptedToken['access_token']
        ];

        $this->execute('GET', $url, [], $headers);
    }

    public function refresh(): void
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

        $this->execute('POST', $url, $body);
    }

    private function execute(string $method, string $url, array $body = [], array $headers = [])
    {
        try {
            $responseClient = $this->httpClient->process($method, $url, $body, $headers)->getBody()->getContents();
        } catch (ClientException $e) {
            throw new Exception(
                json_decode($e->getResponse()->getBody()->getContents())->message,
                $e->getCode()
            );
        }

        $this->converter->fromJWTToFrontend($responseClient);

        return $responseClient;
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