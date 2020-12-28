<?php

declare(strict_types=1);

use Proxy\OAuth\Actions\AuthAction;
use Proxy\OAuth\Actions\AccessAction;
use Proxy\OAuth\Actions\Type\PasswordType;
use Proxy\OAuth\Actions\Type\UsernameType;
use Proxy\OAuth\Helpers\DotEnvConfigStorage;
use Proxy\OAuth\Helpers\GuzzleHttpClient;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\JWTConverter;


require_once __DIR__ . '/../vendor/autoload.php';

$converter = new JWTConverter();

$httpClient = new GuzzleHttpClient();

$configStore = new DotEnvConfigStorage(__DIR__ . '/../');
$configStore->load();


#-------------------------------------
//$authAction = new AuthAction($converter, $httpClient, $configStore);
//
//$username = new UsernameType('tyanrv');
//$password = new PasswordType('hash');
//
//print_r($authAction->login($username, $password));


#-------------------------------------
$token = [
    "token_type" => 'Bearer',
    "expires_in" => "60",
    "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJhcHAiLCJqdGkiOiI3ZGQ0MjZhMThkODk3YWZhOWJjOTBlMzE2MmEyNzA2ZGI5NTUzMzRkMDY1M2QzNzFjMDg0NmZmY2U4MzU5ZjAxYmY4YzI4ZjlmODY1ZGNmMiIsImlhdCI6IjE2MDkxNTE4MjMuNTI5ODg1IiwibmJmIjoiMTYwOTE1MTgyMy41Mjk4OTUiLCJleHAiOiIxNjA5MTUxODgzLjUxNTY4MCIsInN1YiI6ImIwNWJmZjkyLTkzZmYtNGU4Mi1hNjhiLWFkZjAxZjQ4ZjM4OCIsInNjb3BlcyI6W10sImRvbWFpbl9pZCI6IjdhNzhhZDRlLTVkZTQtNDViOC05MzZmLTBlNDdiNWYwMjVmNSJ9.4Kv1vqmMktJPX7dBaM8FJoktqvV4iPSfhStqXBYJq1Zps4YmMAuBrYwlqLb32muBgr8jIjoPj1jlTJdOogs3qTeKUILX_MTusOxzQR9166xAEVx52KdqQV1e9NGQd-i_KHGHv0zwVmMUF5ypF46iLBzQdIROEtFWBZqtjToDjHQa91AxGT1-M737rmh4dRFBmlytJ2G8U2pXodO1Xx4cZ_18pSLTeb2kAGzyQT3wuB3PbEXM5zobx6Mi_wsN7WFxZSf1gavMq_64sZ2ovN0d6vS4DpCOsIZWA9-gTZAC8EE30wEeD3Nzpz0Y1O_ExOtmv7CORm9M_C9mChB7QiVW5Q",
    "refresh_token" => "def50200b408883210d11836844e7cc70bd3337f397cb75c98c46b2d17952790ad82c14648c7cd53bf5ea1217279e8180d6b59f3187821c96e13d5a1410c01229c65f09c6b451204582b4d9f0e9522edca42b3a9df858ca7e6ee9e6249cb0c6515c8da463b86d789d899f6e5930df425ea5b8980d605d720ec79ca5837007b2c68273e67edfbbf7a069227a2272909b8958a19995a4e1c54073b26a605eb9d0e1fdfdfe50830dc9664199fc4b56c7f1b5f2f397c3527bd908658e852392e29f99ab480aa766a9978d21e1e9d3eb7861e3fef6256360509e69deb1e6bc4694036427fb8a01bfc196f708e190db3574574758a679636d68af34d3384abb0e38cc73fa86137c0a09ca5f7023a8801716549e0c8d91e071549b73ec979c766f82a4a4f4b14ecb81e40134adfff5226d0170283ac79f0ac9a0b7546554206572fb439342152ee91a69c6e7c887cda8fef2fa0acaefbc98505594b83c722e23a2e02a06299e45747db986e720d5bd251892fe65d1530a174a6641057d9031f7d662d650ab376c590d0dbc09e2a3718d86442b72fd2e02c553d598907b216a5a4d321aca2341b338065eb9669c242e3a0c54430ade0e9b13e4b7a6399b697"
];
$refreshAction = new AccessAction($converter, $httpClient, $configStore, $token);

// REFRESH
print_r(
    $refreshAction->refresh()
);

// CHECK
//print_r(
//    $refreshAction->check()
//);