<?php

declare(strict_types=1);


namespace Test\Functional;


use Exception;
use Proxy\OAuth\Action\AccessAction;

class AccessActionTest extends WebTestCase
{
    public function testSuccess(): void
    {
        $loginData = $this->login();

        $accessAction = new AccessAction($this->converter, $this->configStore);
        $result = $accessAction->execute($loginData);

        self::assertTrue(is_array($result));

        self::assertArrayHasKey('token_type', $result);
        self::assertArrayHasKey('expires_in', $result);
        self::assertArrayHasKey('access_token', $result);
        self::assertArrayHasKey('refresh_token', $result);

        self::assertEquals('BearerTest', $result['token_type']);
    }

    public function testInvalid(): void
    {
        $result = [
            "token_type" => 'Bearer',
            "expires_in" => "60",
            "access_token" => "asdf",
            "refresh_token" => "ASDF"
        ];

        $accessAction = new AccessAction($this->converter, $this->configStore);

        self::assertTrue(is_array($result));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The refresh token is invalid.');
        $this->expectExceptionCode(400);
        $accessAction->execute($result);
    }
}