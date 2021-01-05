<?php

declare(strict_types=1);


namespace Test\Builder;


use Proxy\OAuth\Interfaces\ConverterInterface;

class JwtConverterBuilder implements ConverterInterface
{


    public function fromFrontendToJWT(array $auth): string
    {
        foreach ($auth as $key => $value) {
            $auth[$key] = str_replace("Test", "", $value);
        }
        return json_encode($auth);
    }

    public function fromJWTToFrontend(string $jwt): array
    {
        $authData = json_decode($jwt, true);

        foreach ($authData as $key => $value) {
            $authData[$key] = $value . 'Test';
        }

        return $authData;
    }
}