<?php declare(strict_types=1);

use Antares\Foundation\Locale\Decimal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class DecimalTest extends TestCase
{
    #[Test]
    #[TestDox('Decimal')]
    public function decimal_object()
    {
        $obj = new Decimal('pt_BR');
        $this->assertInstanceOf(Decimal::class, $obj);
        $this->assertEquals('pt_BR', $obj->getId());
        $this->assertEquals('pt-BR', $obj->getIsoId());
        $this->assertEquals(',', $obj->getDecimalSep());
        $this->assertEquals('.', $obj->getThousandsSep());
        $this->assertEquals('%', $obj->getPercent());
        $this->assertEquals('0', $obj->getZeroDigit());
        $this->assertEquals('#', $obj->getDigit());
        $this->assertEquals('-', $obj->getMinusSign());
        $this->assertEquals('+', $obj->getPlusSign());
        $this->assertEquals('E', $obj->getExponential());
    }
}
