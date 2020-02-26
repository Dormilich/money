<?php

use Dormilich\Money\Money;
use Dormilich\Money\Exception\UnexpectedValueException;
use Dormilich\Money\ISO4217\EUR;
use Dormilich\Money\ISO4217\JPY;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Dormilich\Money\Money
 */
class SetupMoneyTest extends TestCase
{
    public function moneyProvider()
    {
        return [
            [53, '53.00'],
            [53.2, '53.20'],
            [53.20, '53.20'],
            ['53.20', '53.20'],
            [-53, '-53.00'],
        ];
    }

    /**
     * @dataProvider moneyProvider
     */
    public function testCreateMoneyObject($in, $out)
    {
        $money = new EUR($in);

        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame('EUR', $money->getCurrency());
        $this->assertSame($out, $money->getValue());
    }

    public function testCreateMoneyObjectWithoutMinorUnit()
    {
        $money = new JPY(-5319);

        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame('JPY', $money->getCurrency());
        $this->assertSame('-5319', $money->getValue());
    }

    public function testCreateMoneyObjectWithInvalidAmountFails()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Invalid number format for currency EUR.');

        new EUR('53.195');
    }
}
