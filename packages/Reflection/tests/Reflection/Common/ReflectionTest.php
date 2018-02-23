<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Common;

use ApiGen\Reflection\Contract\Reflection\Class_\ClassReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Common\Source\CommonReflection;
use ApiGen\Tests\AbstractParserAwareTestCase;

final class ReflectionTest extends AbstractParserAwareTestCase
{
    /**
     * @var ClassReflectionInterface
     */
    private $reflection;

    protected function setUp()
    {
        $this->parser->parseFilesAndDirectories([__DIR__ . '/Source']);
        $this->reflection = $this->reflectionStorage->getClassReflections()[CommonReflection::class];
    }

    public function testGetName()
    {
        $this->assertSame(CommonReflection::class, $this->reflection->getName());
    }

    public function testGetFileName()
    {
        $this->assertSame(__DIR__ . '/Source/CommonReflection.php', $this->reflection->getFileName());
    }

    public function testClassConstant()
    {
        $methodReflection = $this->reflection->getMethods()['getClass'];
        $this->assertFalse($methodReflection->returnsReference());
    }

    public function testBetterReflectionsConstantsParsing()
    {
        $constants = $this->reflection->getConstants();
        $this->assertCount(2, $constants);

        $thisDirectoryConstant = $constants['THIS_DIRECTORY'];
        $this->assertSame(__DIR__ . '/Source', $thisDirectoryConstant->getValue());

        $thisClassConstant = $constants['THIS_CLASS_METHOD'];
        $this->assertSame(CommonReflection::class . '::methodWithArgs', $thisClassConstant->getValue());
    }
}
