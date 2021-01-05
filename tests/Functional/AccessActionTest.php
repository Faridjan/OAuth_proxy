<?php

declare(strict_types=1);


namespace Test\Functional;


use Exception;
use Proxy\OAuth\Action\AccessAction;

class AccessActionTest extends WebTestCase
{
    public function testSuccess(): void
    {
        $result = $this->login();

        $accessAction = new AccessAction($this->converter, $this->configStore);
        $result = $accessAction->execute($result);

        self::assertTrue(is_array($result));

        self::assertArrayHasKey('token_type', $result);
        self::assertArrayHasKey('expires_in', $result);
        self::assertArrayHasKey('access_token', $result);
        self::assertArrayHasKey('refresh_token', $result);

        self::assertEquals('BearerTest', $result['token_type']);
    }

//    public function testInvalid(): void
//    {
//        $result = [];
//
//        $accessAction = new AccessAction($this->converter, $this->configStore);
//
//        self::assertTrue(is_array($result));
//
//        $this->expectException(Exception::class);
////        $this->expectExceptionMessage('The User Entity not found, check user, domain credentials.');
////        $this->expectExceptionCode(400);
//
//        $accessAction->execute($result);
//    }
}