<?php

declare(strict_types=1);

namespace Proxy\OAuth\Action\Type\Test;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Proxy\OAuth\Action\Type\PasswordType;

class PasswordTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $password = new PasswordType($value = 'password');

        self::assertEquals($value, $password->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must be more than 3 characters.');
        new PasswordType('qwe');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No password set.');
        new PasswordType('');
    }
}
