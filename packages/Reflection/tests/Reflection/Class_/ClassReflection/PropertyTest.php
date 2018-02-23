<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Class_\ClassReflection;

use ApiGen\Reflection\Contract\Reflection\Class_\ClassPropertyReflectionInterface;
use InvalidArgumentException;

final class PropertyTest extends AbstractReflectionClassTestCase
{
    public function testGetProperty()
    {
        $this->assertInstanceOf(
            ClassPropertyReflectionInterface::class,
            $this->reflectionClass->getProperty('publicProperty')
        );
    }

    public function testGetPropertyNonExisting()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->reflectionClass->getProperty('notPresentProperty');
    }

    public function testGetProperties()
    {
        $this->assertCount(4, $this->reflectionClass->getProperties());
    }

    public function testGetOwnProperties()
    {
        $this->assertCount(2, $this->reflectionClass->getOwnProperties());
    }

    public function testGetInheritedProperties()
    {
        $this->assertCount(1, $this->reflectionClass->getInheritedProperties());
    }
}
