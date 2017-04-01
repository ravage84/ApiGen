<?php declare(strict_types=1);

namespace ApiGen\Parser\Tests\Reflection;

use ApiGen\Contracts\Parser\ParserStorageInterface;
use ApiGen\Parser\Broker\Backend;
use ApiGen\Parser\Reflection\AbstractReflection;
use ApiGen\Tests\AbstractContainerAwareTestCase;
use ApiGen\Tests\MethodInvoker;
use Project\ReflectionMethod;
use TokenReflection\Broker;

final class AbstractReflectionTest extends AbstractContainerAwareTestCase
{
    /**
     * @var AbstractReflection
     */
    private $reflectionClass;

    protected function setUp(): void
    {
        /** @var Backend $backend */
        $backend = $this->container->getByType(Backend::class);

        /** @var Broker $broker */
        $broker = $this->container->getByType(Broker::class);
        $broker->processDirectory(__DIR__ . '/ReflectionMethodSource');

        $this->reflectionClass = $backend->getClasses()[ReflectionMethod::class];

        /** @var ParserStorageInterface $parserStorage */
        $parserStorage = $this->container->getByType(ParserStorageInterface::class);
        $parserStorage->setClasses([
            ReflectionMethod::class => $this->reflectionClass
        ]);
    }

    public function testGetName(): void
    {
        $this->assertSame(ReflectionMethod::class, $this->reflectionClass->getName());
    }

    public function testGetPrettyName(): void
    {
        $this->assertSame(ReflectionMethod::class, $this->reflectionClass->getPrettyName());
    }

    public function testIsInternal(): void
    {
        $this->assertFalse($this->reflectionClass->isInternal());
    }

    public function testIsTokenized(): void
    {
        $this->assertTrue($this->reflectionClass->isTokenized());
    }

    public function testGetFileName(): void
    {
        $this->assertStringEndsWith('ReflectionMethod.php', $this->reflectionClass->getFileName());
    }

    public function testGetStartLine(): void
    {
        $this->assertSame(23, $this->reflectionClass->getStartLine());
    }

    public function testGetEndLine(): void
    {
        $this->assertSame(40, $this->reflectionClass->getEndLine());
    }

    public function testGetParsedClasses(): void
    {
        $parsedClasses = MethodInvoker::callMethodOnObject($this->reflectionClass, 'getParsedClasses');
        $this->assertCount(1, $parsedClasses);
    }
}
