<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Parser;

use ApiGen\Reflection\Parser\Parser;
use ApiGen\Reflection\ReflectionStorage;
use ApiGen\Reflection\Tests\Parser\Source\ChildOfSourceObject;
use ApiGen\Reflection\Tests\Parser\Source\SourceObject;
use ApiGen\Tests\AbstractContainerAwareTestCase;

final class ObjectClassTest extends AbstractContainerAwareTestCase
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var ReflectionStorage
     */
    private $reflectionStorage;

    public function setUp()
    {
        $this->parser = $this->container->get(Parser::class);
        $this->parser->parseFilesAndDirectories([__DIR__ . '/Source']);

        $this->reflectionStorage = $this->container->get(ReflectionStorage::class);
    }

    public function testDirect()
    {
        $classReflections = $this->reflectionStorage->getClassReflections();
        $this->assertCount(4, $classReflections);

        $this->assertArrayHasKey(SourceObject::class, $classReflections);
        $this->assertSame(SourceObject::class, $classReflections[SourceObject::class]->getName());
    }

    public function testGetParent()
    {
        $classReflections = $this->reflectionStorage->getClassReflections();

        $classReflection = $classReflections[ChildOfSourceObject::class]->getParentClass();
        $this->assertSame(SourceObject::class, $classReflection->getName());
    }
}
