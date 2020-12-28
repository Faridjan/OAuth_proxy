<?php

declare(strict_types=1);


namespace Proxy\OAuth;


use Proxy\OAuth\Interfaces\ConverterInterface;

class JWTConverter implements ConverterInterface
{

    public function fromFrontendToJWT(array $auth): string
    {
//        return implode('__SEPARATOR___', $auth);
        return json_encode($auth);
    }


    public function fromJWTToFrontend(string $jwt): array
    {
        // TODO: Implement to() method.
//        $joinedToken = join('__SEPARATOR__', $token);
//        $encodeToken = base64_encode($joinedToken);
//        return explode('__SEPARATOR___', $jwt);

        return json_decode($jwt, true);
    }
}