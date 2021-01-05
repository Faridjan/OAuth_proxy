<?php

declare(strict_types=1);


namespace Test\Functional;


use Proxy\OAuth\Action\LoginAction;
use Proxy\OAuth\Action\Type\PasswordType;
use Proxy\OAuth\Action\Type\UsernameType;

class LoginActionTest extends WebTestCase
{

    public function testSuccess(): void
    {
        $authAction = new LoginAction($this->converter, $this->configStore, $this->httpClient);

        $username = new UsernameType('tyanrv');
        $password = new PasswordType('hash');

        print_r($authAction->login($username, $password));
    }
}