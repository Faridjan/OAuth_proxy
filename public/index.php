<?php

declare(strict_types=1);

use Proxy\OAuth\Action\LoginAction;
use Proxy\OAuth\Action\AccessAction;
use Proxy\OAuth\Action\LogoutAction;
use Proxy\OAuth\Action\Type\PasswordType;
use Proxy\OAuth\Action\Type\UsernameType;
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
//$authAction = new LoginAction($converter, $httpClient, $configStore);
//
//$username = new UsernameType('tyanrv');
//$password = new PasswordType('hash');
//
//print_r($authAction->login($username, $password));
////

#-------------------------------------
//$token = [
//    "token_type" => 'Bearer',
//    "expires_in" => "60",
//    "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJhcHAiLCJqdGkiOiJmYzRmMmViMmExZWRhNzllZmRlYjY5MGE3YTlmZmYwZmNjYWI4MTRlZjRiMWQyMjQ2YTE5YjVjMjM0OTU4M2VlMTRjZGQ1ZjkyYzZlMTc5NyIsImlhdCI6IjE2MDkxNjQ4NzEuMDQwNTkwIiwibmJmIjoiMTYwOTE2NDg3MS4wNDA2MDEiLCJleHAiOiIxNjA5MTY0OTMxLjAyODM1MCIsInN1YiI6ImIwNWJmZjkyLTkzZmYtNGU4Mi1hNjhiLWFkZjAxZjQ4ZjM4OCIsInNjb3BlcyI6W10sImRvbWFpbl9pZCI6IjdhNzhhZDRlLTVkZTQtNDViOC05MzZmLTBlNDdiNWYwMjVmNSJ9.gQcpakvHP_QqFK1aKTUSnCjAAWj_uW3X-EUmebg5TKUC7qOm5KMy46OpUB4qhI7IlcfPR6FV7TnE49KK7b1xVGqIya19V2iXLTjDnScjH2oIfr14-kMsqpZWoYaiHYzGjX5RtTt2SomvXiPn3FD2o0SQuW4jOTIeZ1ZsFoes54MgDlswSFqvMCXhuu8CsFJqDrjq1b-GeOZycsZcGspBpeRO4LRzqcq1BStGVVsSkAAgcTNLhIw4Yjk6c2Oergt8OSbk3NgOQoAg8CyI5dphQkagFRpOzKysK9tSkQjbQz_tBmKJcTtK0Hj5X6T5P9E5Q8vd3X4AqG8ku5XNcGAIAw",
//    "refresh_token" => "def50200477cbe918be32dad8ba087229183aa22cb9da6149cb9762b79f9927c74ee4ed97d965c6fb8f0f754127e76de9bbf9d6c860280a6f9028226861805ecfeaa04fb4c8f13c0dde33a6066c8cfbba24280819f1c5585942c67b5384c8417158d4652c4f9da555d432016a85d81afd991f84eefcbd6782ec68f7182887dd7a07964c85d5dd0cb4663f935324f2b9399fa444861d9147eef7a22d9be4cea631f364ed67dbf7c75ed701150a0594c0967338483798d89b1fff52eb96a1422cf5e60845a543a399fb839c0d5abafc9c0d9972ae4ce8a6d7aa7091827ae517e030f496f8004d357abc24d7ff22ff375b20196de88716eb9443930df24f5134e8b6008aa446a94356bb198c58c1595e9cfd5fb64f9d1a7ee78fe1afe612d4f5d690c84d3cde3b078f6c050fb8e8ac873ce187593918ba0b1824003f613381c255acbc526eebbb80fead2a3213be713024671fb4a92c9fdacba9ff8e7eb3d9d1491eac571ef67f4da71b192df081eb51a1cf397f2541ec363a17c3715b5ef73cc65085fd6594cafeb91f0fd8c9ed1a3dcdcd7a2110f63a6cb1edcdebda07aff5c4dfa2d0ac64e1d652c3393150c4b3aaa4211ecdfc688d7a253538567"
//];
//$refreshAction = new AccessAction($converter, $httpClient, $configStore, $token);
//
//print_r($refreshAction());
//
//$logout = new LogoutAction($converter, $httpClient, $configStore, $token, $refreshAction);
//
//var_dump($logout->logout());