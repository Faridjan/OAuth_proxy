<?php

declare(strict_types=1);


namespace Proxy\OAuth\Handlers;

use Proxy\OAuth\Handlers\Type\PasswordType;
use Proxy\OAuth\Handlers\Type\UsernameType;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;

class LoginHandler
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

    public function login(UsernameType $username, PasswordType $password)
    {
        $baseUrl = trim($this->configStore->get('OAUTH_BASE_URL'), '/');
        $loginUrl = trim($this->configStore->get('OAUTH_URL'), '/');

        $url = $baseUrl . '/' . $loginUrl;

        $body = [
            'grant_type' => $this->configStore->get('OAUTH_GRANT_TYPE'),
            'username' => $username->getValue(),
            'password' => $password->getValue(),
            'client_id' => $this->configStore->get('OAUTH_CLIENT_ID'),
            'client_secret' => $this->configStore->get('OAUTH_CLIENT_SECRET'),
            'access_type' => $this->configStore->get('OAUTH_ACCESS_TYPE'),
            'domain' => $this->configStore->get('OAUTH_DOMAIN')
        ];

        $responseClient = $this->httpClient->post($url, $body);

        $this->converter->fromJWTToFrontend($responseClient);

        return $responseClient;
    }
}