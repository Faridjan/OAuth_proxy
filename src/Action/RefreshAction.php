<?php

declare(strict_types=1);

namespace Proxy\OAuth\Action;

use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class RefreshAction
{
    private ConfigStoreInterface $config;
    private HttpClientInterface $httpClient;

    private string $url;

    public function __construct(ConfigStoreInterface $config, HttpClientInterface $httpClient)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;

        $baseUrl = trim($this->config->get('OAUTH_BASE_URL'), '/');
        $loginUrl = trim($this->config->get('OAUTH_URL'), '/');

        $this->url = $baseUrl . '/' . $loginUrl;
    }

    public function refresh(string $refreshToken): string
    {
        $body = [
            'grant_type' => $this->config->get('OAUTH_REFRESH_GRANT_TYPE'),
            'refresh_token' => $refreshToken,
            'client_id' => $this->config->get('OAUTH_CLIENT_ID'),
            'client_secret' => $this->config->get('OAUTH_CLIENT_SECRET'),
        ];

        return $this->httpClient->post($this->url, $body, [])->getBody()->getContents();
    }
}
