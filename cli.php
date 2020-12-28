<?php

use Proxy\OAuth\Handlers\AuthAction;
use Proxy\OAuth\Handlers\Type\PasswordType;
use Proxy\OAuth\Handlers\Type\UsernameType;
use Proxy\OAuth\Helpers\DotEnvConfigStorage;
use Proxy\OAuth\Helpers\GuzzleHttpClient;
use Proxy\OAuth\Interfaces\ConverterInterface;

require_once __DIR__ . '/vendor/autoload.php';

class OAuthConverter implements ConverterInterface
{

    public function from()
    {
        // TODO: Implement from() method.
    }

    public function to()
    {
        // TODO: Implement to() method.
    }
}

$converter = new OAuthConverter();
$httpClient = new GuzzleHttpClient();
$configStore = new DotEnvConfigStorage(__DIR__);
$configStore->load();

$loginAction = new AuthAction($converter, $httpClient, $configStore);


$username = new UsernameType('Farid');
$password = new PasswordType('hash');

print_r($loginAction->login($username, $password));
