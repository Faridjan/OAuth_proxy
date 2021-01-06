<?php

declare(strict_types=1);

namespace Proxy\OAuth\Action\Type\Test;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Proxy\OAuth\Action\Type\UsernameType;

class UsernameTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $username = new UsernameType($value = 'username');

        self::assertEquals($value, $username->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Username must be more than 3 characters.');
        new UsernameType('use');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No Username set.');
        new UsernameType('');
    }
}
