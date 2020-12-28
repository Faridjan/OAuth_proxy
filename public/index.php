<?php

declare(strict_types=1);

use Proxy\OAuth\Handlers\LoginHandler;
use Proxy\OAuth\Handlers\AccessHandler;
use Proxy\OAuth\Handlers\Type\PasswordType;
use Proxy\OAuth\Handlers\Type\UsernameType;
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
//$authAction = new LoginHandler($converter, $httpClient, $configStore);
//
//$username = new UsernameType('tyanrv');
//$password = new PasswordType('hash');
//
//print_r($authAction->login($username, $password));


#-------------------------------------
$token = [
    "token_type" => 'Bearer',
    "expires_in" => "60",
    "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJhcHAiLCJqdGkiOiI3MTM5NmZkN2M2N2M1ZTQ3N2I5NzE1NTJmYTM4OWQ0ZDVkZTJiNTFmOTEzOWNkOGFjMTNjZjI4Yzk0ZDVhOWVlMTNjNzkyZTg4ZmEzZmVjOSIsImlhdCI6IjE2MDkxNjEzNjEuMTI3MTExIiwibmJmIjoiMTYwOTE2MTM2MS4xMjcxMjIiLCJleHAiOiIxNjA5MTYxNDIxLjExNDcwNCIsInN1YiI6ImIwNWJmZjkyLTkzZmYtNGU4Mi1hNjhiLWFkZjAxZjQ4ZjM4OCIsInNjb3BlcyI6W10sImRvbWFpbl9pZCI6IjdhNzhhZDRlLTVkZTQtNDViOC05MzZmLTBlNDdiNWYwMjVmNSJ9.h9Z3bzEeHpoPpKvV7Py-82RCuaiKb7wt9GVQr7oxpqfIACNoLl53cMl-ZGM_0VSFlYB3DFqkD-yTrD5MGcVbjAmGuHzIEOE79B_sNFv_l9fDc0LhKUN_fLVVPBz8aep28WFxgW58GRS5gRd4Kj77ymF3VqUkGwa_45IJUMjPWPYb8ubXfSGLgimN46cxqONe16bBYOVuyFVy7gaHFevr5GMmVCKVjGnuCh5nvJ9VO9bZg-rfFg8A6ROeOwb9yoEdofS-jZxVwJ85416qcIUGvv7rE8KHEolLOKkR832md2XMiC27vXJF2iny3RYF04UbluMpH8V61RR6hgRZ8JPMxA",
    "refresh_token" => "def502004ac793c697dd87624e90c75982dc3e5c42e782a33e62f4639c5d806a1a113ddaf9f8f2c03fc1980cbf8abb3c735134b8e8c7ba8caae10f2be788f9e58e886937adb39f9e2ada0e929dc04fd84196e1e9d559d65cec0fa685d03a5ef02078a8a6fe51855f51b514c5de25c0e7b7a67f6470fc0f17416cc9bf5235aa842a113c27dce4560fe4d8b82b7ca48ca9d277978d6fcff8bb7e78bd8e5c38b77242dd0d62c482966d3781c40a9b009fbd31e938aa96ec94207d558bbe5d514cd85f9975ee12778a30f7c75a117888488d7aa3ade368de51cfcaebb07f24af55859ec26310d7f7e2577736b43976f90bf039c3406380395f7572ff46b1abd6fa05ed224ff6df9547010638a31ddd39cab6b21911a891db1a955af44094c41172647c97fce35bfa992284d345ed544183cbd914b1d0468c81804eab88c16f91819633d20e4a841cd24e1e4b0d9879a951253df85bbd8aaf0c4d0f4cf406badefaec733f6b8375d7bc55bded22d48d1de8370d9fce1c3183337c77cdf2f3035c0b18a1524c514e23a289eb5b644b0d710f1cd908fbb41f745c331d9e605f037e8d4252c5f1d1f532a06eacc0f9120af722710a4981a293c4a1192aa418"
];
$refreshAction = new AccessHandler($converter, $httpClient, $configStore, $token);

print_r($refreshAction());