<?php

declare(strict_types=1);


namespace Proxy\OAuth\Actions;


use Exception;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class RefreshAction
{
    private ConverterInterface $converter;
    private HttpClientInterface $httpClient;
    private ConfigStoreInterface $configStore;

    public function __construct(
        ConverterInterface $converter,
        HttpClientInterface $httpClient,
        ConfigStoreInterface $configStore
    ) {
        $this->converter = $converter;
        $this->httpClient = $httpClient;
        $this->configStore = $configStore;
    }

    public function refresh(string $token)
    {
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $loginUrl = trim($this->configStore->get('OAUTH_URL'), '/');

        $url = $baseUrl . '/' . $loginUrl;

        $decryptedToken = $this->converter->from($token);

        $body = [
            'grant_type' => $this->configStore->get('OAUTH_REFRESH_GRANT_TYPE'),
            'refresh_token' => $token,
            'client_id' => $this->configStore->get('OAUTH_CLIENT_ID'),
            'client_secret' => $this->configStore->get('OAUTH_CLIENT_SECRET'),
        ];

        try {
            $responseClient = $this->httpClient->post($url, $body);
        } catch (Exception $e) {
            return [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }

        $this->converter->to(
            [
                'access_token' => $responseClient->access_token,
                'refresh_token' => $responseClient->refresh_token,
            ]
        );

        return $responseClient;
    }


}