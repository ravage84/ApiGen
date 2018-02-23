<?php declare(strict_types=1);

namespace ApiGen\Reflection\Tests\Reflection\Trait_\TraitReflection;

use ApiGen\Reflection\Contract\Reflection\Trait_\TraitReflectionInterface;
use ApiGen\Reflection\Tests\Reflection\Trait_\TraitReflection\Source\ClassUsingTrait;
use ApiGen\Reflection\Tests\Reflection\Trait_\TraitReflection\Source\SimpleTrait;
use ApiGen\Reflection\Tests\Reflection\Trait_\TraitReflection\Source\ToBeAliasedTrait;
use ApiGen\Tests\AbstractParserAwareTestCase;

final class TraitReflectionTest extends AbstractParserAwareTestCase
{
    /**
     * @var TraitReflectionInterface
     */
    private $traitReflection;

    protected function setUp()
    {
        $this->parser->parseFilesAndDirectories([__DIR__ . '/Source']);
        $traitReflections = $this->reflectionStorage->getTraitReflections();
        $this->traitReflection = $traitReflections[SimpleTrait::class];
    }

    public function testName()
    {
        $this->assertSame(SimpleTrait::class, $this->traitReflection->getName());
        $this->assertSame('SimpleTrait', $this->traitReflection->getShortName());
        $this->assertSame(
            'ApiGen\Reflection\Tests\Reflection\Trait_\TraitReflection\Source',
            $this->traitReflection->getNamespaceName()
        );
    }

    public function testUsers()
    {
        $users = $this->traitReflection->getUsers();
        $this->assertCount(1, $users);
        $this->assertArrayHasKey(ClassUsingTrait::class, $users);
    }

    public function testTraitMethodAliases()
    {
        $this->assertSame([
            'renamedMethod' => ToBeAliasedTrait::class . '::aliasedParentMethod',
        ], $this->traitReflection->getTraitAliases());
    }

    public function testFileName()
    {
        $this->assertSame(__DIR__ . '/Source/SimpleTrait.php', $this->traitReflection->getFileName());
    }
}
