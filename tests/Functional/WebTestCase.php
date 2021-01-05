<?php

declare(strict_types=1);


namespace Functional;


use Builder\JwtConverterBuilder;
use PHPUnit\Framework\TestCase;
use Proxy\OAuth\Helpers\DotEnvConfigStorage;
use Proxy\OAuth\Helpers\GuzzleHttpClient;
use Proxy\OAuth\Interfaces\ConverterInterface;

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

        $this->configStore = new DotEnvConfigStorage(__DIR__ . '/../');
        $this->configStore->load();
    }
}