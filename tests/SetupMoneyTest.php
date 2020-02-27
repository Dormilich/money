<?php

use Dormilich\Money\Money;
use Dormilich\Money\Exception\UnexpectedValueException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Dormilich\Money\Money
 */
class SetupMoneyTest extends TestCase
{
    public function testCreateMoneyObjectWithNonNumericInputFails()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The given value "abc" does not represent a valid number.');

        Money::EUR('abc');
    }

    public function testCreateMoneyObjectWithInvalidCurrencyFails()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The given value "Beer" is not a valid ISO-4217 currency.');

        Money::Beer(42.8);
    }

    public function moneyProvider()
    {
        return [
            [53, '53.00'],
            [-53, '-53.00'],
            [53.2, '53.20'],
            [-53.2, '-53.20'],
            [53.20, '53.20'],
            [-53.20, '-53.20'],
            ['53.20', '53.20'],
            ['+53.20', '53.20'],
            ['-53.20', '-53.20'],
        ];
    }

    /**
     * @dataProvider moneyProvider
     */
    public function testCreateMoneyObjectWithMinorUnit($in, $out)
    {
        $money = Money::EUR($in);

        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame('EUR', $money->getCurrency());
        $this->assertSame($out, $money->getValue());
    }

    public function testCreateMoneyObjectWithoutMinorUnit()
    {
        $money = Money::JPY(-5319);

        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame('JPY', $money->getCurrency());
        $this->assertSame('-5319', $money->getValue());
    }

    public function testCreateMoneyObjectWithoutValueIsZero()
    {
        $money = Money::JPY();

        $this->assertSame('0', $money->getValue());
    }

    public function testCreateMoneyObjectWithInvalidAmountFails()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Invalid number of fractional digits encountered.');

        Money::EUR('53.195');
    }

    public function floatProvider()
    {
        return [
            [53, '53'],
            [-53, '-53'],
            [53.2, '53.2'],
            [-53.2, '-53.2'],
            [53.20, '53.2'],
            [-53.20, '-53.2'],
            ['50', '50'],
            ['53.0', '53'],
            ['53.20', '53.2'],
            ['+53.20', '53.2'],
            ['-53.20', '-53.2'],
            [M_PI, '3.1415926535898'],
        ];
    }

    /**
     * @dataProvider floatProvider
     */
    public function testCreateMoneyObjectWithoutFractionalRestriction($in, $out)
    {
        $unit = Money::XXX($in); // no currency

        $this->assertInstanceOf(Money::class, $unit);
        $this->assertSame('XXX', $unit->getCurrency());
        $this->assertSame($out, $unit->getValue());
    }
}
