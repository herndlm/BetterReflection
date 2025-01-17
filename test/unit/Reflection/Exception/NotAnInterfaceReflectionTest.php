<?php

declare(strict_types=1);

namespace Roave\BetterReflectionTest\Reflection\Exception;

use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Ast\Locator;
use Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator;
use Roave\BetterReflectionTest\BetterReflectionSingleton;
use Roave\BetterReflectionTest\Fixture;

/** @covers \Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection */
class NotAnInterfaceReflectionTest extends TestCase
{
    private Locator $astLocator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->astLocator = BetterReflectionSingleton::instance()->astLocator();
    }

    public function testFromClass(): void
    {
        $reflector = new DefaultReflector(new SingleFileSourceLocator(__DIR__ . '/../../Fixture/ExampleClass.php', $this->astLocator));
        $exception = NotAnInterfaceReflection::fromReflectionClass($reflector->reflectClass(Fixture\ExampleClass::class));

        self::assertInstanceOf(NotAnInterfaceReflection::class, $exception);
        self::assertSame(
            'Provided node "' . Fixture\ExampleClass::class . '" is not interface, but "class"',
            $exception->getMessage(),
        );
    }

    public function testFromTrait(): void
    {
        $reflector = new DefaultReflector(new SingleFileSourceLocator(__DIR__ . '/../../Fixture/ExampleClass.php', $this->astLocator));
        $exception = NotAnInterfaceReflection::fromReflectionClass($reflector->reflectClass(Fixture\ExampleTrait::class));

        self::assertInstanceOf(NotAnInterfaceReflection::class, $exception);
        self::assertSame(
            'Provided node "' . Fixture\ExampleTrait::class . '" is not interface, but "trait"',
            $exception->getMessage(),
        );
    }
}
