<?php

declare(strict_types=1);


namespace Test\Functional;


use Exception;
use Proxy\OAuth\Action\LoginAction;
use Proxy\OAuth\Action\Type\PasswordType;
use Proxy\OAuth\Action\Type\UsernameType;

class LoginActionTest extends WebTestCase
{
    public function testSuccess(): void
    {
        $result = $this->login();

        self::assertTrue(is_array($result));

        self::assertArrayHasKey('token_type', $result);
        self::assertArrayHasKey('expires_in', $result);
        self::assertArrayHasKey('access_token', $result);
        self::assertArrayHasKey('refresh_token', $result);

        self::assertEquals('BearerTest', $result['token_type']);
    }

    public function testInvalid(): void
    {
        $authAction = new LoginAction($this->converter, $this->configStore, $this->httpClient);

        $username = new UsernameType('user');
        $password = new PasswordType('password');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The User Entity not found, check user, domain credentials.');
        $this->expectExceptionCode(400);

        $authAction->login($username, $password);
    }
}