<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Class_\ClassMethodReflection;

use ApiGen\Reflection\Contract\Reflection\Class_\ClassMethodReflectionInterface;
use ApiGen\Reflection\Contract\Reflection\Class_\ClassReflectionInterface;
use ApiGen\Reflection\Contract\Reflection\Method\MethodParameterReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Class_\ClassMethodReflection\Source\ClassMethod;
use ApiGen\Tests\AbstractParserAwareTestCase;

final class ClassMethodReflectionTest extends AbstractParserAwareTestCase
{
    /**
     * @var ClassMethodReflectionInterface
     */
    private $methodReflection;

    protected function setUp()
    {
        $this->parser->parseFilesAndDirectories([__DIR__ . '/Source']);

        $classReflections = $this->reflectionStorage->getClassReflections();
        $classReflection = $classReflections[ClassMethod::class];
        $this->methodReflection = $classReflection->getMethod('methodWithArgs');
    }

    public function testName()
    {
        $this->assertSame('methodWithArgs', $this->methodReflection->getName());
    }

    public function testInstance()
    {
        $this->assertInstanceOf(ClassMethodReflectionInterface::class, $this->methodReflection);
    }

    public function testGetDeclaringClass()
    {
        $this->assertInstanceOf(ClassReflectionInterface::class, $this->methodReflection->getDeclaringClass());
        $this->assertSame(ClassMethod::class, $this->methodReflection->getDeclaringClassName());
    }

    public function testModificators()
    {
        $this->assertFalse($this->methodReflection->isAbstract());
        $this->assertFalse($this->methodReflection->isFinal());
        $this->assertFalse($this->methodReflection->isPrivate());
        $this->assertFalse($this->methodReflection->isProtected());
        $this->assertTrue($this->methodReflection->isPublic());
        $this->assertFalse($this->methodReflection->isStatic());
    }

    public function testGetParameters()
    {
        $parameters = $this->methodReflection->getParameters();
        $this->assertCount(3, $parameters);
        $this->assertInstanceOf(MethodParameterReflectionInterface::class, $parameters['url']);
        $this->assertSame(['url', 'data', 'headers'], array_keys($parameters));
    }

    public function testReturnReference()
    {
        $this->assertFalse($this->methodReflection->returnsReference());
    }
}
