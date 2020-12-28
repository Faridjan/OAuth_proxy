<?php

declare(strict_types=1);

use Proxy\OAuth\Actions\AuthAction;
use Proxy\OAuth\Actions\RefreshAction;
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
//$username = new UsernameType('farid');
//$password = new PasswordType('hash');
//
//print_r($authAction->login($username, $password));


#-------------------------------------
$refreshAction = new RefreshAction($converter, $httpClient, $configStore);
print_r(
    $refreshAction->refresh(
        'def50200233310968fae260d6dce50337c9e4b7686f42b0fd249017af23ccc35173fbf16398943b06cece6a19280cedff39a61916b6cbbb96a15d3f7ef95abb5fcb049fcce5f63bb00f5241fa00318aa84049ed9ec285a4aa63e821a3509760be95e26e7c87968a7372d1c89504b6881ea8efcfc4f316183240405074ba383f249a5e773194e81da0e37b6cbb9c3223a55335e310bca45589dda70aeaeb3d2b4720cf07ea26fdc5f9ef40b776743e87a7de77a444741aebc56cebf5fc0c9aa9528262fda5845080c23ab2c7d936fe2f5c7fa2a2f17ee3e0863662135aa234091ec86c536225d67768f9c74a51e84aa9ef05a11aa5887946a428a4a427c86c715fbf847f3b9824e5ac2599dd3f3c61da6ccef9fdbc4f01028827f89c27ef31e2e888b6f86a457cd6257b3ae4149d08e8702e151791bee27a51ba87489c04d871bcd5e149e680056e61efbe2f19c179a71f0b9e5ea6c71cf17234487c1be92a76f5399408b5fcd9d387a73b9fdd9d343d4afa69de1822eaa44287fd4d1cca2361fc55de79c9c2ddee34956ad38455f90e2166f8e622b9bb43923904e019f9f96125133bbcb598b460f49527d3f3e4eb6d26721731ca0d01b81303ce5'
    )
);
