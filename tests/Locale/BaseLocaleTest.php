<?php declare(strict_types=1);

use Antares\Foundation\Locale\BaseLocale;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class BaseLocaleTest extends TestCase
{
    #[Test]
    #[TestDox('BaseLocale')]
    public function base_locale_object()
    {
        $obj = new BaseLocale('pt_BR');
        $this->assertInstanceOf(BaseLocale::class, $obj);
        $this->assertEquals('pt_BR', $obj->getId());
        $this->assertEquals('pt-BR', $obj->getIsoId());
    }
}
