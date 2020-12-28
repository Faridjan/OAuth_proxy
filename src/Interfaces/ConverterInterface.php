<?php

declare(strict_types=1);


namespace Proxy\OAuth\Interfaces;


interface ConverterInterface
{
    public function from(string $token): string;

    public function to(array $tokenChunks): string;
}
