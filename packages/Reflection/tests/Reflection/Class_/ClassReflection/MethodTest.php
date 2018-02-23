<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Class_\ClassReflection;

use ApiGen\Reflection\Contract\Reflection\Class_\ClassMethodReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Class_\ClassReflection\Source\AccessLevels;
use InvalidArgumentException;

final class MethodTest extends AbstractReflectionClassTestCase
{
    public function testNames()
    {
        $this->assertSame(AccessLevels::class, $this->reflectionClass->getName());
    }

    public function testGetMethod()
    {
        $this->assertInstanceOf(
            ClassMethodReflectionInterface::class,
            $this->reflectionClass->getMethod('publicMethod')
        );
    }

    public function testGetMethodNonExisting()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->reflectionClass->getMethod('notPresentMethod');
    }

    public function testGetMethods()
    {
        $methods = $this->reflectionClass->getMethods();
        $this->assertCount(5, $methods);

        $methodsNames = array_keys($methods);
        $this->assertSame([
            'publicMethod',
            'getSomeStuff',
            'protectedMethod',
            'publicTraitMethod',
            'getSomeParentStuff',
        ], $methodsNames);
    }

    public function testGetOwnMethods()
    {
        $this->assertCount(3, $this->reflectionClass->getOwnMethods());
    }

    public function testGetInheritedMethods()
    {
        $this->assertCount(1, $this->reflectionClass->getInheritedMethods());
    }
}
