<?php

use Dormilich\Money\Money;
use Dormilich\Money\Exception\InvalidCurrencyException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Dormilich\Money\Money
 */
class CalculationTest extends TestCase
{
    public function testAddDifferentCurrenciesFails()
    {
        $this->expectException(InvalidCurrencyException::class);
        $this->expectExceptionMessage('It is not possible to add Yen to Euro.');

        $eur = Money::EUR(0);
        $jpy = Money::JPY(0);

        $eur->add($jpy);
    }

    public function testSubtractDifferentCurrenciesFails()
    {
        $this->expectException(InvalidCurrencyException::class);
        $this->expectExceptionMessage('It is not possible to subtract Yen from Euro.');

        $eur = Money::EUR(0);
        $jpy = Money::JPY(0);

        $eur->subtract($jpy);
    }

    public function testDifferentCurrenciesAreNeverEqual()
    {
        $eur = Money::EUR(0);
        $jpy = Money::JPY(0);

        $this->assertFalse($eur->equals($jpy));
    }

    /**
     * @depends testDifferentCurrenciesAreNeverEqual
     */
    public function testTwoObjectsAreEqual()
    {
        $a = Money::EUR(10);
        $b = Money::EUR(10);

        $this->assertNotSame($a, $b);
        $this->assertSame($a->getValue(), $b->getValue());
        $this->assertTrue($a->equals($b));
    }

    /**
     * @depends testDifferentCurrenciesAreNeverEqual
     */
    public function testTwoObjectsAreNotEqual()
    {
        $a = Money::EUR(10);
        $b = Money::EUR(42);

        $this->assertNotSame($a, $b);
        $this->assertNotSame($a->getValue(), $b->getValue());
        $this->assertFalse($a->equals($b));
    }

    /**
     * @depends testTwoObjectsAreEqual
     * @depends testTwoObjectsAreNotEqual
     */
    public function testAddCurrencies()
    {
        $a = Money::EUR(10);
        $b = Money::EUR(42);
        $c = Money::EUR(52);

        $this->assertTrue($a->add($b)->equals($c));
    }

    /**
     * @depends testTwoObjectsAreEqual
     * @depends testTwoObjectsAreNotEqual
     */
    public function testSubtractCurrencies()
    {
        $a = Money::EUR(10);
        $b = Money::EUR(42);
        $c = Money::EUR(52);

        $this->assertTrue($c->subtract($b)->equals($a));
    }
}
