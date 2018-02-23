<?php declare(strict_types=1);

namespace ApiGen\Tests\Console\Helper;

use ApiGen\Console\Helper\ProgressBar;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\ProgressBar as SymfonyProgressBar;
use Symfony\Component\Console\Output\NullOutput;

final class ProgressBarTest extends TestCase
{
    /**
     * @var ProgressBar
     */
    private $progressBar;

    protected function setUp()
    {
        $this->progressBar = new ProgressBar(new NullOutput);
    }

    public function testInit()
    {
        $this->assertNull(Assert::readAttribute($this->progressBar, 'bar'));

        $this->progressBar->init(50);

        /** @var SymfonyProgressBar $bar */
        $bar = Assert::readAttribute($this->progressBar, 'bar');
        $this->assertInstanceOf(SymfonyProgressBar::class, $bar);
        $this->assertSame(50, $bar->getMaxSteps());
    }

    public function testIncrement()
    {
        $this->progressBar->increment();

        $this->progressBar->init(50);
        $this->progressBar->increment(20);

        /** @var SymfonyProgressBar $bar */
        $bar = Assert::readAttribute($this->progressBar, 'bar');
        $this->assertSame(20, $bar->getProgress());

        $this->progressBar->increment(30);
        $this->assertSame(50, $bar->getProgress());
    }
}
