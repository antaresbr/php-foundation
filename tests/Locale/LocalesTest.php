<?php declare(strict_types=1);

use Antares\Foundation\Locale\Currency;
use Antares\Foundation\Locale\Decimal;
use Antares\Foundation\Locale\Locales;
use Antares\Foundation\Obj;
use Antares\Foundation\Tests\Resources\Dummy;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class LocalesTest extends TestCase
{
    private function ensure_app_function() {
        if (!function_exists('app')) {
            function app(): mixed
            {
                return new Dummy();
            }
        }
    }

    private function assert_currency_pt_BR(Currency $currency): void{
        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertEquals(app()->getLocale(), $currency->getId());
        $this->assertEquals('pt-BR', $currency->getIsoId());
        $this->assertEquals('BRL', $currency->getCode());
        $this->assertEquals(',', $currency->getDecimalSep());
        $this->assertEquals('.', $currency->getThousandsSep());
        $this->assertEquals('-', $currency->getMinusSign());
        $this->assertEquals('+', $currency->getPlusSign());
        $this->assertEquals('R$', $currency->getSymbol());
        $this->assertEquals('prefix', $currency->getAffixType());
        $this->assertEquals("R\$\u{A0}", $currency->getPositiveAffix());
        $this->assertEquals("-R\$\u{A0}", $currency->getNegativeAffix());
    }

    private function assert_decimal_pt_BR(Decimal $decimal): void{
        $this->assertInstanceOf(Decimal::class, $decimal);
        $this->assertEquals(app()->getLocale(), $decimal->getId());
        $this->assertEquals('pt-BR', $decimal->getIsoId());
        $this->assertEquals('pt-BR', $decimal->getIsoId());
        $this->assertEquals(',', $decimal->getDecimalSep());
        $this->assertEquals('.', $decimal->getThousandsSep());
        $this->assertEquals('%', $decimal->getPercent());
        $this->assertEquals('0', $decimal->getZeroDigit());
        $this->assertEquals('#', $decimal->getDigit());
        $this->assertEquals('-', $decimal->getMinusSign());
        $this->assertEquals('+', $decimal->getPlusSign());
        $this->assertEquals('E', $decimal->getExponential());
    }

    #[Test]
    #[TestDox('Default currency (pt_BR)')]
    public function locales_default_currency()
    {
        $this->ensure_app_function();

        $obj = Locales::currency();
        $this->assert_currency_pt_BR($obj);
    }

    #[Test]
    #[TestDox('Currency (fr_FR)')]
    public function locales_currency_fr_FR()
    {
        $obj = Locales::currency('fr_FR');
        $this->assertInstanceOf(Currency::class, $obj);
        $this->assertEquals('fr_FR', $obj->getId());
        $this->assertEquals('fr-FR', $obj->getIsoId());
        $this->assertEquals('EUR', $obj->getCode());
        $this->assertEquals(',', $obj->getDecimalSep());
        $this->assertEquals("\u{202F}", $obj->getThousandsSep());
        $this->assertEquals('-', $obj->getMinusSign());
        $this->assertEquals('+', $obj->getPlusSign());
        $this->assertEquals('€', $obj->getSymbol());
        $this->assertEquals('suffix', $obj->getAffixType());
        $this->assertEquals("\u{A0}€", $obj->getPositiveAffix());
        $this->assertEquals("\u{A0}€", $obj->getNegativeAffix());
    }

    #[Test]
    #[TestDox('Currency (de_DE)')]
    public function locales_currency_de_DE()
    {
        $obj = Locales::currency('de_DE');
        $this->assertInstanceOf(Currency::class, $obj);
        $this->assertEquals('de_DE', $obj->getId());
        $this->assertEquals('de-DE', $obj->getIsoId());
        $this->assertEquals('EUR', $obj->getCode());
        $this->assertEquals(',', $obj->getDecimalSep());
        $this->assertEquals(".", $obj->getThousandsSep());
        $this->assertEquals('-', $obj->getMinusSign());
        $this->assertEquals('+', $obj->getPlusSign());
        $this->assertEquals('€', $obj->getSymbol());
        $this->assertEquals('suffix', $obj->getAffixType());
        $this->assertEquals("\u{A0}€", $obj->getPositiveAffix());
        $this->assertEquals("\u{A0}€", $obj->getNegativeAffix());
    }

    #[Test]
    #[TestDox('Currency (de_CH)')]
    public function locales_currency_de_CH()
    {
        $obj = Locales::currency('de_CH');
        $this->assertInstanceOf(Currency::class, $obj);
        $this->assertEquals('de_CH', $obj->getId());
        $this->assertEquals('de-CH', $obj->getIsoId());
        $this->assertEquals('CHF', $obj->getCode());
        $this->assertEquals('.', $obj->getDecimalSep());
        $this->assertEquals("\u{2019}", $obj->getThousandsSep());
        $this->assertEquals('-', $obj->getMinusSign());
        $this->assertEquals('+', $obj->getPlusSign());
        $this->assertEquals('CHF', $obj->getSymbol());
        $this->assertEquals('prefix', $obj->getAffixType());
        $this->assertEquals("CHF\u{A0}", $obj->getPositiveAffix());
        $this->assertEquals('CHF-', $obj->getNegativeAffix());
    }

    #[Test]
    #[TestDox('Currency (pt_BR)')]
    public function locales_currency_pt_BR()
    {
        $obj = Locales::currency('pt_BR');
        $this->assert_currency_pt_BR($obj);
    }

    #[Test]
    #[TestDox('Count Locales::currencies array')]
    public function locale_currencies_count()
    {
        //-- valid currency objects
        $this->assertEquals(4, count(Obj::get(Locales::class, 'currencies')));
    }

    #[Test]
    #[TestDox('Default decimal (pt_BR)')]
    public function locales_default_decimal()
    {
        $this->ensure_app_function();

        $obj = Locales::decimal();
        $this->assert_decimal_pt_BR($obj);
    }

    #[Test]
    #[TestDox('Decimal (fr_FR)')]
    public function locales_decimal_fr_FR()
    {
        $obj = Locales::decimal('fr_FR');
        $this->assertInstanceOf(Decimal::class, $obj);
        $this->assertEquals('fr_FR', $obj->getId());
        $this->assertEquals('fr-FR', $obj->getIsoId());
        $this->assertEquals(',', $obj->getDecimalSep());
        $this->assertEquals("\u{202F}", $obj->getThousandsSep());
        $this->assertEquals('%', $obj->getPercent());
        $this->assertEquals('0', $obj->getZeroDigit());
        $this->assertEquals('#', $obj->getDigit());
        $this->assertEquals('-', $obj->getMinusSign());
        $this->assertEquals('+', $obj->getPlusSign());
        $this->assertEquals('E', $obj->getExponential());
    }

    #[Test]
    #[TestDox('Decimal (de_DE)')]
    public function locales_decimal_de_DE()
    {
        $obj = Locales::decimal('de_DE');
        $this->assertInstanceOf(Decimal::class, $obj);
        $this->assertEquals('de_DE', $obj->getId());
        $this->assertEquals('de-DE', $obj->getIsoId());
        $this->assertEquals(',', $obj->getDecimalSep());
        $this->assertEquals('.', $obj->getThousandsSep());
        $this->assertEquals('%', $obj->getPercent());
        $this->assertEquals('0', $obj->getZeroDigit());
        $this->assertEquals('#', $obj->getDigit());
        $this->assertEquals('-', $obj->getMinusSign());
        $this->assertEquals('+', $obj->getPlusSign());
        $this->assertEquals('E', $obj->getExponential());
    }

    #[Test]
    #[TestDox('Decimal (de_CH)')]
    public function locales_decimal_de_CH()
    {
        $obj = Locales::decimal('de_CH');
        $this->assertInstanceOf(Decimal::class, $obj);
        $this->assertEquals('de_CH', $obj->getId());
        $this->assertEquals('de-CH', $obj->getIsoId());
        $this->assertEquals('.', $obj->getDecimalSep());
        $this->assertEquals("\u{2019}", $obj->getThousandsSep());
        $this->assertEquals('%', $obj->getPercent());
        $this->assertEquals('0', $obj->getZeroDigit());
        $this->assertEquals('#', $obj->getDigit());
        $this->assertEquals('-', $obj->getMinusSign());
        $this->assertEquals('+', $obj->getPlusSign());
        $this->assertEquals('E', $obj->getExponential());
    }

    #[Test]
    #[TestDox('Decimal (pt_BR)')]
    public function locales_decimal_pt_BR()
    {
        $obj = Locales::decimal();
        $this->assert_decimal_pt_BR($obj);
    }

    #[Test]
    #[TestDox('Count Locales::currencies array')]
    public function locale_decimals_count()
    {
        //-- valid decimal objects
        $this->assertEquals(4, count(Obj::get(Locales::class, 'decimals')));
    }
}
