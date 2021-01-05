<?php

declare(strict_types=1);


namespace Test\Functional;

use PHPUnit\Framework\TestCase;
use Proxy\OAuth\Action\LoginAction;
use Proxy\OAuth\Action\Type\PasswordType;
use Proxy\OAuth\Action\Type\UsernameType;
use Proxy\OAuth\Helpers\DotEnvConfigStorage;
use Proxy\OAuth\Helpers\GuzzleHttpClient;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Test\Builder\JwtConverterBuilder;

class WebTestCase extends TestCase
{

    protected ConverterInterface $converter;
    protected string $username;
    protected string $password;
    protected GuzzleHttpClient $httpClient;
    protected DotEnvConfigStorage $configStore;

    protected function setUp(): void
    {
        parent::setUp();

        $this->converter = new JwtConverterBuilder();
        $this->username = 'tyanrv';
        $this->password = 'hash';

        $this->httpClient = new GuzzleHttpClient();

        $this->configStore = new DotEnvConfigStorage(__DIR__ . '/../../');
        $this->configStore->load();
    }

    protected function login(): array
    {
        $authAction = new LoginAction($this->converter, $this->configStore, $this->httpClient);

        $username = new UsernameType('tyanrv');
        $password = new PasswordType('hash');

        return $authAction->login($username, $password);
    }
}