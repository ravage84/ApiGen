<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Method\MethodReflection;

use ApiGen\Reflection\Contract\Reflection\Class_\ClassMethodReflectionInterface;
use ApiGen\Reflection\Contract\Reflection\Class_\ClassReflectionInterface;
use ApiGen\Reflection\Contract\Reflection\Method\MethodParameterReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Method\MethodReflection\Source\ParameterMethodClass;
use ApiGen\Tests\AbstractParserAwareTestCase;

final class MethodParameterReflectionTest extends AbstractParserAwareTestCase
{
    /**
     * @var ClassReflectionInterface
     */
    private $classReflection;

    /**
     * @var MethodParameterReflectionInterface
     */
    private $parameterReflection;

    protected function setUp()
    {
        $this->parser->parseFilesAndDirectories([__DIR__ . '/Source']);

        $this->classReflection = $this->reflectionStorage->getClassReflections()[ParameterMethodClass::class];

        $methodReflection = $this->classReflection->getMethod('methodWithArgs');
        $this->parameterReflection = $methodReflection->getParameters()['url'];
    }

    public function testInstance()
    {
        $this->assertInstanceOf(MethodParameterReflectionInterface::class, $this->parameterReflection);
    }

    public function testGetTypeHint()
    {
        $this->assertSame('int|string', $this->parameterReflection->getTypeHint());
    }

    public function testGetDescription()
    {
        $this->assertSame('the URL of the API endpoint', $this->parameterReflection->getDescription());
    }

    public function testType()
    {
        $this->assertFalse($this->parameterReflection->isArray());
        $this->assertFalse($this->parameterReflection->isVariadic());
    }

    public function testGetDeclaringFunction()
    {
        $this->assertInstanceOf(
            ClassMethodReflectionInterface::class,
            $this->parameterReflection->getDeclaringMethod()
        );
    }

    public function testGetDeclaringFunctionName()
    {
        $this->assertSame(
            'methodWithArgs',
            $this->parameterReflection->getDeclaringMethodName()
        );
    }

    public function testGetDeclaringClass()
    {
        $this->assertInstanceOf(
            ClassReflectionInterface::class,
            $this->parameterReflection->getDeclaringClass()
        );

        $this->assertSame(
            ParameterMethodClass::class,
            $this->parameterReflection->getDeclaringClassName()
        );
    }

    public function testIsPassedByReference()
    {
        $this->assertFalse($this->parameterReflection->isPassedByReference());
    }
}
