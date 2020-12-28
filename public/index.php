<?php

declare(strict_types=1);

use Proxy\OAuth\Handlers\AuthAction;
use Proxy\OAuth\Handlers\RefreshAction;
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
//$authAction = new AuthAction($converter, $httpClient, $configStore);
//
//$username = new UsernameType('farid');
//$password = new PasswordType('hash');
//
//print_r($authAction->login($username, $password));


#-------------------------------------
$token = [
    "token_type" => 'Bearer',
    "expires_in" => "60",
    "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJhcHAiLCJqdGkiOiI1MGIyM2MwNjk2MWMxZmRhYWMyYWIyZTRmMzBlZGE2MzA4MGI4NDFmNzExNDkwM2YyOTE1NmRlNjU0MjMwNjVjYTMwYWRiNzJmZTc1MzgxYyIsImlhdCI6IjE2MDkxNDQ4ODguNTc2NzEyIiwibmJmIjoiMTYwOTE0NDg4OC41NzY3MTYiLCJleHAiOiIxNjA5MTQ0OTQ4LjU2NjU0OCIsInN1YiI6IjAzNDY3NzQ5LWI1ZGEtNGM4NC1iNzY2LTkwY2QxMTk5YmZkNSIsInNjb3BlcyI6W119.3SdLhPANabJmGCP-70oTp-9c49SROUWcApypgJ4D8K0fGuLr_6U1Y8bG0Utky0htZ7jBdpOcWlSaTrcn5glTvqqHmXa1icXI8ujgxM6qaXLEkgnsOPkwV9HSU3kuWd2PL0nvTRFcD-AlfQXv26PYQ8xDdv1HLkDFyeM7QxFCSAjXlJYf_JStuTrK6YkFYLZoa6fFHlCqClHhr_XlilwYhKMSom_gUJ15v8WhN4iLj47lkZ3n5dff-yoky71kvhr90e32GkYzBaV4_gAaELdYK_N9_WbwF6-scmPlkcctHVE1RPh0kAlqS0XlQV9EXbkJ_-UV-DaEscQgjwBpaBs1qw",
    "refresh_token" => "def502009bd24971badb44958a1e3e9e95fad6b6f3804849191c5aa415f196ebce6611a4174a4cbd7a767bc7923a47b9a92d75521e10ca2d49b011a2d923690e792253576775bd9996d8aae204453b1bde699ef3666d11f18296010ef9797e3c849c7be8671e16ff34bfed93317bf614ba08e865e916fc66e94bc1745aefee706a5449396399d8ff33dad362e734ee5f8294b996ba6eb81a98564ed2f3b6437e187d5d4fdc2bf7f3c2eb191ca14a53d74db5fe65cbb3cb0317c296c33c7a48d292b92eda98477473391fd9a82798d435f39d670f7b6090bb772bd0fef05d0262256d8aa87a8c7a8858dcc07f59b474ef3bfb0975fcd4fb2898cfdea1483edaec2c7ec64801c0edf2c123c67148da0521a13a724b40501c28698093ef2fea825f35481228f14816afde001f0cad1f8329bc09e740cfc7c2c8e6622b13eaa61327c54a9cf50e86d9ede0eb3927b7adb9309e99913f5267cacabf78374fcd0b7eacaa49b4c6a05c36b54fd866e1c95fa42c6a2ebaaaa8c7d6583bec24dd212c6bc327f7dde49d076d2935313eda075477c76edbfbcfa56a6168f11422680ec0bf29165514a1e21a398662c28a84aa057c599dc4c078496efaecaf7ea0"
];
$refreshAction = new RefreshAction($converter, $httpClient, $configStore, $token);

// REFRESH
//print_r(
//    $refreshAction->refresh()
//);

// CHECK
print_r(
    $refreshAction->check()
);