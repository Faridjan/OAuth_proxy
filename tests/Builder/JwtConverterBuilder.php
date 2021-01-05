<?php

declare(strict_types=1);


namespace Builder;


use Proxy\OAuth\Interfaces\ConverterInterface;

class JwtConverterBuilder implements ConverterInterface
{

    public function fromFrontendToJWT(array $auth): string
    {
        foreach ($auth as $key => $value) {
            $auth[$key] = $value . 'Test';
        }
        return json_encode($auth);
    }

    public function fromJWTToFrontend(string $jwt): array
    {
        $authData = json_decode($jwt, true);

        foreach ($authData as $key => $value) {
            $authData[$key] = str_replace("Test", "", $value);
        }

        return $authData;
    }
}