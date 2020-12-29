<?php

declare(strict_types=1);

use Proxy\OAuth\Action\LoginAction;
use Proxy\OAuth\Action\AccessAction;
use Proxy\OAuth\Action\LogoutAction;
use Proxy\OAuth\Action\Type\PasswordType;
use Proxy\OAuth\Action\Type\UsernameType;
use Proxy\OAuth\Helpers\DotEnvConfigStorage;
use Proxy\OAuth\Helpers\GuzzleHttpClient;


require_once __DIR__ . '/../vendor/autoload.php';

class MyConverter implements \Proxy\OAuth\Interfaces\ConverterInterface {

    public function fromFrontendToJWT(array $auth): string
    {
        return json_encode($auth);
    }

    public function fromJWTToFrontend(string $jwt): array
    {
        return json_decode($jwt, true);
    }
}

$httpClient = new GuzzleHttpClient();

$configStore = new DotEnvConfigStorage(__DIR__ . '/../');
$configStore->load();

$converter = new MyConverter();

#-------------------------------------
//$authAction = new LoginAction($converter, $configStore, $httpClient);
//
//$username = new UsernameType('tyanrv');
//$password = new PasswordType('hash');
//
//print_r($authAction->login($username, $password));
//

#-------------------------------------
$token = [
    "token_type" => 'Bearer',
    "expires_in" => "60",
    "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJhcHAiLCJqdGkiOiIxYTIyYzE1MjUyZTk2MGFmOGQxOTQzYzM1MzY0MmRiMzNkY2NjMzA3OGRkZjMzMGI4ZDc5NjY2MDY4YzY5ZjU1MGVlODExNjhlZmU5ZTQ5ZiIsImlhdCI6IjE2MDkyMjE3MzEuMzcyNDkyIiwibmJmIjoiMTYwOTIyMTczMS4zNzI1MzUiLCJleHAiOiIxNjA5MjIyNjMxLjA4MTAyNCIsInN1YiI6IjlkMDc4ZWZkLTlmM2QtNDE3Zi05YmE3LTgwYzlkMDk4MWM0MiIsInNjb3BlcyI6W10sImRvbWFpbl9pZCI6IjUxMTZlOTNlLWI0NGYtNDcyZS04YTcyLWM3ZTQ4YzcyN2FlMiJ9.GCHSiY0__pjVr9UOeUiBeUHrvf5bC5e4FDgYSeQERhiiX3CyEiZZtm_ia8WryVgZvLMTeopbc1plC_MH5L2n5KCvHkaFrcM0Dq781Me5Q2fZNYSDisX462M-sKIY8W8FZA6lyjs2YHKxnCmyknvfbTK3-qRa441MR5J06AgV-DB2AUiiXqHwH9CeBwrS5g_nsCKS2L5-_C8yS-ObdVKj1GlWzV-pn75axBwZAaIH8A7BuLdsPODYWaMDEh7xcPTITDvH53TmNLFZidG0zpidMyr0f-ke9Le0LrOsl4qimgdqL8z5vNtLB9y_6vMKMSCcD6YF3TLHWoFdXMYj0bkrzQ",
    "refresh_token" => "def50200ce7fcf5d7546cd7c190149c52bfac621bcf44c1c6cdc54e61e2c061acd7eba50ba46d5d2303b48db7828c4c54991bdc20dd629894c31497fd7caa9f60b73652575364cfe2d7e241e986993c2ab2c7bf7870edb34ad15847e39e84da5c19d5db0115fc17dc3666e2986e28267a4b350502b30df9d9b1ef92cbc252ac7d1bace15b82ed288eabb4514c3482cbd025a549b40556dd4ab8cb251e54f94c8c88b3b5a6de62257de38c651446de9e0787aee0a4fca2ff83a37ee812257b8ee4144b3f393b9fed7dc56afd4f27ac8cf1dc00a0e5e8a0e8db8507cf128f475d796eebae924cef1ea8b22aa0969b5685ed7cbd00ae19f942b960e18dc0297b2b1f487adb55e6ec596f9c7758dc266a6481aa93fccee421434a371c4eac69230a22070af69340da6821f438ad3d7778c209cfd2daa51d633706f363b4437baaae5c4441a0516386726b0cba13101b1caaee66a510e2a6a123578435d8cbe85970118ba9a08947f7a1c625bc76bbd377882f2cc9e2ab1bc3045ecd00896e0dfa11a092894018eea07426f72b4afb3ad0be59f5fba7b1a55a4f6ae9d90cf6f4ac23a6e039bec22bb462b048f34c4ef3fd76b44dee657b6c635b80c85ee"
];
$accessAction = new AccessAction($converter, $configStore, $token);

print_r($accessAction());

$logout = new LogoutAction($converter, $configStore, $token);

var_dump($logout->logout());