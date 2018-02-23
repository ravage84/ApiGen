<?php declare(strict_types=1);

namespace ApiGen\Element\Cache;

use ApiGen\Reflection\ReflectionStorage;

/**
 * Invoke all old reflection conversions, so they can be collected.
 */
final class ReflectionWarmUpper
{
    /**
     * @var ReflectionStorage
     */
    private $reflectionStorage;

    public function __construct(ReflectionStorage $reflectionStorage)
    {
        $this->reflectionStorage = $reflectionStorage;
    }

    public function warmUp()
    {
        $this->warmUpClassReflections();
        $this->warmUpInterfaceReflections();
        $this->warmUpTraitReflections();
        $this->warmUpFunctionReflections();
    }

    private function warmUpClassReflections()
    {
        foreach ($this->reflectionStorage->getClassReflections() as $classReflection) {
            $classReflection->getOwnConstants();
            $classReflection->getOwnProperties();
            foreach ($classReflection->getOwnMethods() as $methodReflection) {
                $methodReflection->getParameters();
            }
        }
    }

    private function warmUpInterfaceReflections()
    {
        foreach ($this->reflectionStorage->getInterfaceReflections() as $interfaceReflection) {
            $interfaceReflection->getOwnConstants();
            foreach ($interfaceReflection->getOwnMethods() as $methodReflection) {
                $methodReflection->getParameters();
            }
        }
    }

    private function warmUpTraitReflections()
    {
        foreach ($this->reflectionStorage->getTraitReflections() as $traitReflection) {
            $traitReflection->getOwnProperties();
            foreach ($traitReflection->getOwnMethods() as $methodReflection) {
                $methodReflection->getParameters();
            }
        }
    }

    private function warmUpFunctionReflections()
    {
        foreach ($this->reflectionStorage->getFunctionReflections() as $functionReflection) {
            $functionReflection->getParameters();
        }
    }
}
