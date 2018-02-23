<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Method\MethodReflection;

use ApiGen\Reflection\Contract\Reflection\Method\MethodParameterReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Method\MethodReflection\Source\ParameterMethodClass;
use ApiGen\Tests\AbstractParserAwareTestCase;

final class ParameterWithConstantDefalutValueTest extends AbstractParserAwareTestCase
{
    /**
     * @var MethodParameterReflectionInterface
     */
    private $localConstantParameterReflection;

    /**
     * @var MethodParameterReflectionInterface
     */
    private $classConstantParameterReflection;

    protected function setUp()
    {
        $this->parser->parseFilesAndDirectories([__DIR__ . '/Source']);

        $classReflection = $this->reflectionStorage->getClassReflections()[ParameterMethodClass::class];

        $methodReflection = $classReflection->getMethod('methodWithConstantDefaultValue');
        $this->localConstantParameterReflection = $methodReflection->getParameters()['where'];
        $this->classConstantParameterReflection = $methodReflection->getParameters()['when'];
    }

    public function testGetTypeHint()
    {
        $this->assertSame('string', $this->localConstantParameterReflection->getTypeHint());
        $this->assertSame('string', $this->classConstantParameterReflection->getTypeHint());
    }

    // @todo - fix after constant dump is fixed
    //public function testType()
    //{
    //    $this->assertSame('HERE', $this->localConstantParameterReflection->getDefaultValueDefinition());
    //    $this->assertSame('TODAY', $this->classConstantParameterReflection->getDefaultValueDefinition());
    //}
}
