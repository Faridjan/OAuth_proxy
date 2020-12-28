<?php

declare(strict_types=1);


namespace Proxy\OAuth\Action\Type;


use Webmozart\Assert\Assert;

class PasswordType
{
    private string $password;

    public function __construct(string $password)
    {
        Assert::notEmpty($password);
        Assert::minLength($password, 3);
        $this->password = $password;
    }

    public function getValue(): string
    {
        return $this->password;
    }
}