<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Class_\ClassReflection;

use ApiGen\Reflection\Contract\Reflection\Class_\ClassConstantReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Class_\ClassReflection\Source\AccessLevels;
use InvalidArgumentException;

final class ConstantsTest extends AbstractReflectionClassTestCase
{
    public function testName()
    {
        $this->assertSame(AccessLevels::class, $this->reflectionClass->getName());
    }

    public function testGetConstants()
    {
        $this->assertCount(2, $this->reflectionClass->getConstants());
    }

    public function testGetOwnConstants()
    {
        $this->assertCount(1, $this->reflectionClass->getOwnConstants());
    }

    public function testHasConstant()
    {
        $this->assertFalse($this->reflectionClass->hasConstant('NOT_EXISTING'));
        $this->assertTrue($this->reflectionClass->hasConstant('LEVEL'));
    }

    public function testGetConstant()
    {
        $this->assertInstanceOf(ClassConstantReflectionInterface::class, $this->reflectionClass->getConstant('LEVEL'));
    }

    public function testGetOwnConstant()
    {
        $this->assertInstanceOf(
            ClassConstantReflectionInterface::class,
            $this->reflectionClass->getOwnConstant('LEVEL')
        );
    }

    public function testGetOwnConstantNonExisting()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->reflectionClass->getOwnConstant('NON_EXISTING');
    }

    public function testGetConstantNonExisting()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->reflectionClass->getConstant('NON_EXISTING');
    }

    public function testGetInheritedConstants()
    {
        $this->assertCount(1, $this->reflectionClass->getInheritedConstants());
    }
}
