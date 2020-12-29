<?php

declare(strict_types=1);

namespace Proxy\OAuth\Action\Type;

use Webmozart\Assert\Assert;

class UsernameType
{
    private string $username;

    public function __construct(string $username)
    {
        Assert::notEmpty($username);
        Assert::minLength($username, 3);
        $this->username = $username;
    }

    public function getValue(): string
    {
        return $this->username;
    }
}
