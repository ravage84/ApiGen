<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Class_\ClassPropertyReflection;

use ApiGen\Reflection\Contract\Reflection\Class_\ClassPropertyReflectionInterface;
use ApiGen\Reflection\Contract\Reflection\Class_\ClassReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Class_\ClassPropertyReflection\Source\ReflectionProperty;
use ApiGen\Tests\AbstractParserAwareTestCase;

final class ClassPropertyReflectionTest extends AbstractParserAwareTestCase
{
    /**
     * @var ClassPropertyReflectionInterface
     */
    private $propertyReflection;

    protected function setUp()
    {
        $this->parser->parseFilesAndDirectories([__DIR__ . '/Source']);

        $classReflections = $this->reflectionStorage->getClassReflections();
        $classReflection = $classReflections[ReflectionProperty::class];
        $this->propertyReflection = $classReflection->getProperty('memberCount');
    }

    public function testName()
    {
        $this->assertSame('memberCount', $this->propertyReflection->getName());
        $this->assertSame(
            'ApiGen\Reflection\Tests\Reflection\Class_\ClassPropertyReflection\Source',
            $this->propertyReflection->getNamespaceName()
        );
    }

    public function testInstance()
    {
        $this->assertInstanceOf(ClassPropertyReflectionInterface::class, $this->propertyReflection);
    }

    public function testGetTypeHint()
    {
        $this->assertSame('int', $this->propertyReflection->getTypeHint());
    }

    public function testGetDeclaringClass()
    {
        $this->assertInstanceOf(ClassReflectionInterface::class, $this->propertyReflection->getDeclaringClass());
        $this->assertSame(ReflectionProperty::class, $this->propertyReflection->getDeclaringClassName());
    }

    public function testDefaults()
    {
        $this->assertTrue($this->propertyReflection->isDefault());
        $this->assertSame(52, $this->propertyReflection->getDefaultValue());
    }

    public function testIsStatic()
    {
        $this->assertFalse($this->propertyReflection->isStatic());
    }

    public function testLines()
    {
        $this->assertSame(10, $this->propertyReflection->getStartLine());
        $this->assertSame(10, $this->propertyReflection->getEndLine());
    }
}
