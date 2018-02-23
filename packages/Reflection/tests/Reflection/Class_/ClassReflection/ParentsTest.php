<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Class_\ClassReflection;

use ApiGen\Reflection\Contract\Reflection\Class_\ClassReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Class_\ClassReflection\Source\AccessLevels;
use ApiGen\Reflection\Tests\Reflection\Class_\ClassReflection\Source\ParentClass;
use ApiGen\Tests\AbstractParserAwareTestCase;
use ArrayAccess;

final class ParentsTest extends AbstractParserAwareTestCase
{
    /**
     * @var ClassReflectionInterface
     */
    private $classReflection;

    /**
     * @var ClassReflectionInterface
     */
    private $classReflectionOfParentClass;

    protected function setUp()
    {
        $this->parser->parseFilesAndDirectories([__DIR__ . '/Source']);
        $classReflections = $this->reflectionStorage->getClassReflections();
        $this->classReflection = $this->reflectionStorage->getClassReflections()[AccessLevels::class];
        $this->classReflectionOfParentClass = $classReflections[ParentClass::class];
    }

    public function testGetParentClass()
    {
        $this->assertInstanceOf(ClassReflectionInterface::class, $this->classReflection->getParentClass());
    }

    public function testGetParentClassName()
    {
        $this->assertSame(ParentClass::class, $this->classReflection->getParentClassName());
    }

    public function testGetParentClasses()
    {
        $this->assertCount(1, $this->classReflection->getParentClasses());
    }

    public function testGetSubClasses()
    {
        $this->assertCount(2, $this->classReflectionOfParentClass->getSubClasses());
    }

    public function testIsSubclassOf()
    {
        $this->assertTrue($this->classReflection->isSubclassOf(ParentClass::class));
        $this->assertFalse($this->classReflection->isSubclassOf(ArrayAccess::class));
    }
}
