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
    "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJhcHAiLCJqdGkiOiIwOWFjNTgzNzIxMGVhYjI4MWI4NTBjODE5OWE4MzFmM2ZmMmZkYWI3NWFhY2YyZjcwZDE0MGVkMTBlNzgyYWYyYzRjY2M1NzM3NjI4OWU4MiIsImlhdCI6IjE2MDkxNTczOTYuODU0MTgwIiwibmJmIjoiMTYwOTE1NzM5Ni44NTQxODQiLCJleHAiOiIxNjA5MTU3NDU2Ljg0MjQ0OCIsInN1YiI6ImIwNWJmZjkyLTkzZmYtNGU4Mi1hNjhiLWFkZjAxZjQ4ZjM4OCIsInNjb3BlcyI6W10sImRvbWFpbl9pZCI6IjdhNzhhZDRlLTVkZTQtNDViOC05MzZmLTBlNDdiNWYwMjVmNSJ9.B3CW-AmD87CWcAhAQSkfusMLnllfFbc05M6cukL574j8FF7GHh0fKsMMdGO0BUB7GSU5n7odb4j77xD--aXt_HRqrqawwLya9yOIs-uuR8LvNVHf9xH52ZRfRPPBnnsvNagkHz1rL83t9e3nLt5L_Dg56UjmXZ1kRha7ioFojZECPHWsVqinBIlN0UgtGEFxH-spq6jPRp9PAxsKY4vPNPJeuQOeQ0Ze5HLmTczKcfiMIffspjFKE3lsdHZXUBW_I6Pll0ViIMz1ANc1bBUPZoS-yG6QoKdUhtx_56ZGFjIcqlwDpMRGzNKxnZoeWx3OmgRg5oJegkN9SxY9dnG4FA",
    "refresh_token" => "def502000f6ad5ce22b9831894286da76d1605bc103f26c996c1a2a2d96f4bba3086922959c7ee68ed75e2ad5bb6d0f47268480ea758e7976e5fc7bd5e5054dabaf4dfa1162b4c13425188c34927923bbf4c44919efa58697566c44cecf5ab38159faea5591cbf2afca9b5655f9acc3d8466b28c191f78c0f34b51f4eb81c593f83cd14694d29d857f66f05d98f8a31add2840ed82359b19201c96a4a115a87eb1fa624e35f0afb6527fa122b6753ee01f3449d6790b22419a3ca453f65829e41973b334a91dacc637c292b6fb6b3b00d92b237c43037b9540aaabc38c8d4ad76f7e49ee076af3823fbe2fc2af2d51a4b3f9410016f7e9ff0f4182386420ef7b1959e2ced779335ad194cd65274b90394201425d4dd356a805dc0193f6a5e116e8e03a6ab023406011573f93c2424ea2f6ab03e9d621acbfc37268e54ceafc60f61ee3932157f4016c60373bdd4fc8a3b3070899ac46902ecddd7593919438eeb9c7ff003e480612bd46e9336f3c8c807d2cbf880ab0fc46b46bcae84eeecb4b352883447ac10e758321eb5efccfd368cecd506fd44d7161d7f61222b845800c273b2bbda81efe27824bc320b9e43b0fe383be16058e7a62c1bb7f"
];
$refreshAction = new AccessHandler($converter, $httpClient, $configStore, $token);

$refreshAction();