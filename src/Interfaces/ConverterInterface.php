<?php

declare(strict_types=1);

namespace Proxy\OAuth\Interfaces;

interface ConverterInterface
{
    public function fromFrontendToJWT(array $auth): string;

    public function fromJWTToFrontend(string $jwt): array;
}
