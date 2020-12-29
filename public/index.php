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


#-------------------------------------
//$token = [
//    "token_type" => 'Bearer',
//    "expires_in" => "60",
//    "access_token" => "eyJ0eXAasdasdiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJhcHAiLCJqdGkiOiI4N2VjMzFiMmM4YzI0Yzc1Y2QxZWIyNDZhN2QyNDYzMTNhYWU5Yjc1ZGNmMDQ4ZTAyMzJlMjhlOWFkZDFkYTgxZGFiZDAzZDEzZTIyNjFhOSIsImlhdCI6IjE2MDkyMjI1NjEuMzM4OTk2IiwibmJmIjoiMTYwOTIyMjU2MS4zMzkwMDciLCJleHAiOiIxNjA5MjIzNDYxLjI5NTU2OCIsInN1YiI6IjlkMDc4ZWZkLTlmM2QtNDE3Zi05YmE3LTgwYzlkMDk4MWM0MiIsInNjb3BlcyI6W10sImRvbWFpbl9pZCI6IjUxMTZlOTNlLWI0NGYtNDcyZS04YTcyLWM3ZTQ4YzcyN2FlMiJ9.VmMC_JgiSbYDxugam7T7MZOvIfp8xaqRmRgUynt73SlmAa0beZgp4Fq6HZcVlZpY4nbHQg6aIu5PE4H2MBAo7dFp6ql2wXNdOTKoE60nZpz-FuWE42pSaZFOPd0_J3dwdL8G-zNGZmEGeobboniy4A6RQJu2ifyZOm1reR7lXSdC6_mq7i2VitasqPq7Ol-s3GM07p5rtEAKF_LNV22inS2xolzWl5fm62ezXGaB5W6P04eFzOW_Ome6NuEGe6I9N09v3-AET_YyCMawk4p9HTOjPnfTOOnsnriAGvRnbn_b9wWDdzkF3iomivZJLcv3Vx8Wfov28lSamKZLrZkhxQ",
//    "refresh_token" => "def502000ca588349a1a7b004e7f1f15e13ec5a599ffc7b9c8c0c02e7c189ff35a2dd44e5ca90245dbf8c3dad0d27bcf601442c4bc05d17bcdae1a7505c23337c62a215c55932e903bb75c9c59a1dfd9acc3a93dd1c5c814c269f7ac14ed1b54f2522327ffbce8d34f9d19edb9cea569524501eeab813c0866ba490b211ef6766612727f51588c4414e1ede810637c97225f987c598b7a15d8e5017122ddc9bbb29f5deba70d3992abbf30bd3534cfbd5945619279aa7454b134fae7849c34f475dab9bcc1958e66176f03a836dbd28d16e27f1d57e2a53849497307376bcabe3b4ec643c88ea5dcf520c88b38fca508feb9f169a435e3574265948c821ff7baa2bf34d72f50bd48586cd4a4cb899b99eaeda075ba6d428dd6b309ca669ff0616621c73310af2798d28017de0525466a2dad9a4646a37a5dc283970148f3c8586ff602cacf6843fdbf5bd5788e6a85cbe867fcf5e36b37d3326eb4cb30189b0ae0b8719c88a72a9275e07857cfb7bbcf2e81bf5d9bfa93f926baba50c64d0b1e30eff466be1910cd0cb0c5cd02b41042ba097428823d26623fa301398576cd829333f2894f26c2cb4455f6dc95c408a6889420982726a1673c0327"
//];
//$accessAction = new AccessAction($converter, $configStore, $token);
//
//print_r($accessAction());

//$logout = new LogoutAction($converter, $configStore, $token);
//
//var_dump($logout->execute());