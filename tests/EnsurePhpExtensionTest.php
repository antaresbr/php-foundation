<?php declare(strict_types=1);

use Antares\Foundation\EnsurePhpExtension;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class EnsurePhpExtensionTest extends TestCase
{
    #[Test]
    public function runtime_exception()
    {
        $this->expectException(RuntimeException::class);
        EnsurePhpExtension::isInstalled('banana');
    }

    #[Test]
    public function intl_extension()
    {
        $this->assertTrue(EnsurePhpExtension::isInstalled('intl'));
        $this->assertTrue(EnsurePhpExtension::intl());
        
    }
}
