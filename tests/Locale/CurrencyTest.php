<?php declare(strict_types=1);

use Antares\Foundation\Locale\Currency;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class CurrencyTest extends TestCase
{
    #[Test]
    #[TestDox('Currency')]
    public function currency_object()
    {
        $obj = new Currency('pt_BR');
        $this->assertInstanceOf(Currency::class, $obj);
        $this->assertEquals('pt_BR', $obj->getId());
        $this->assertEquals('pt-BR', $obj->getIsoId());
        $this->assertEquals('BRL', $obj->getCode());
        $this->assertEquals(',', $obj->getDecimalSep());
        $this->assertEquals('.', $obj->getThousandsSep());
        $this->assertEquals('-', $obj->getMinusSign());
        $this->assertEquals('+', $obj->getPlusSign());
        $this->assertEquals('R$', $obj->getSymbol());
        $this->assertEquals('prefix', $obj->getAffixType());
        $this->assertEquals("R\$\u{A0}", $obj->getPositiveAffix());
        $this->assertEquals("-R\$\u{A0}", $obj->getNegativeAffix());
    }
}
