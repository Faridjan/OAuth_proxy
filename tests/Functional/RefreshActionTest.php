<?php


namespace Test\Functional;

use Exception;
use Proxy\OAuth\Action\LogoutAction;
use Proxy\OAuth\Action\RefreshAction;

class RefreshActionTest extends WebTestCase
{
    public function testSuccess(): void {
        $refreshAction = new RefreshAction($this->configStore, $this->httpClient);

        $token = $this->login();
        $authData = json_decode($this->converter->fromFrontendToJWT($token), true);

        $result = $refreshAction->refresh($authData['refresh_token']);
        $result = json_decode($result, true);

        self::assertArrayHasKey('token_type', $result);
        self::assertArrayHasKey('expires_in', $result);
        self::assertArrayHasKey('access_token', $result);
        self::assertArrayHasKey('refresh_token', $result);

    }

    public function testIncorrectRefresh()
    {
        $refreshAction = new RefreshAction($this->configStore, $this->httpClient);

        $token = $this->login();
        $authData = json_decode($this->converter->fromFrontendToJWT($token), true);

        $result = $refreshAction->refresh($authData['refresh_token']);
        $result = json_decode($result, true);

        $result['access_token'] .= '__INCORRECT___';
        $result['refresh_token'] .= '__INCORRECT___';

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The refresh token is invalid.');
        $this->expectExceptionCode(400);

        $refreshAction->refresh($result['refresh_token']);
    }
}