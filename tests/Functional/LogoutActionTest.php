<?php


namespace Test\Functional;

use Exception;
use Proxy\OAuth\Action\LogoutAction;

class LogoutActionTest extends WebTestCase
{

    public function testSuccess(): void
    {
        $logoutAction = new LogoutAction($this->converter, $this->configStore, $this->httpClient);

        $token = $this->login();
        $result = $logoutAction->execute($token);

        self::AssertTrue($result);
    }

    public function testIncorrectRefresh(): void
    {
        $logoutAction = new LogoutAction($this->converter, $this->configStore, $this->httpClient);

        $token = $this->login();
        $token['access_token'] .= '__INCORRECT___';
        $token['refresh_token'] .= '__INCORRECT___';

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The refresh token is invalid.');
        $this->expectExceptionCode(400);

        $logoutAction->execute($token);
    }

}