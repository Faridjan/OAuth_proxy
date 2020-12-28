<?php

declare(strict_types=1);


namespace Proxy\OAuth;


use Proxy\OAuth\Interfaces\ConverterInterface;

class JWTConverter implements ConverterInterface
{

    public function from(string $token): string
    {
        // TODO: Implement from() method.
//        $decodedToken = base64_decode($token);
//        $arrayToken = explode('__SEPARATOR__', $decodedToken);
        return $token;
    }

    public function to(array $token): string
    {
        // TODO: Implement to() method.
//        $joinedToken = join('__SEPARATOR__', $token);
//        $encodeToken = base64_encode($joinedToken);
        return $token['refresh_token'];
    }
}