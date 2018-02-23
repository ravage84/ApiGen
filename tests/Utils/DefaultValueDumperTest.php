<?php declare(strict_types=1);

namespace ApiGen\Tests\Utils;

use ApiGen\Utils\DefaultValueDumper;
use PHPUnit\Framework\TestCase;

final class DefaultValueDumperTest extends TestCase
{
    /**
     * @var DefaultValueDumper
     */
    private $defaultValueDumper;

    protected function setUp()
    {
        $this->defaultValueDumper = new DefaultValueDumper;
    }

    /**
     * @dataProvider getDumpData()
     *
     * @param mixed
     */
    public function testDump($value, string $expected)
    {
        $this->assertSame($expected, $this->defaultValueDumper->dumpValue($value));
    }

    /**
     * @return mixed[]
     */
    public function getDumpData(): array
    {
        return [
            [11, '11'],
            [true, 'true'],
            [['cat', 'dog'], "array (\n" .
                "  0 => 'cat',\n" .
                "  1 => 'dog',\n" .
                ')', ],
        ];
    }
}
