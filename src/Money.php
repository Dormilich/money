<?php

namespace Dormilich\Money;

use Brick\Math\BigDecimal;
use Dormilich\Money\Exception\InvalidCurrencyException;
use Dormilich\Money\Exception\UnexpectedValueException;
use Dormilich\Money\Parser\DecimalParser;
use Dormilich\Money\Parser\FloatParser;
use Dormilich\Money\Parser\ParserInterface;

/**
 * This class represents monatary currencies with debit & credit functionality.
 */
abstract class Money implements Currency
{
    /**
     * @var BigDecimal
     */
    private $units;

    /**
     * Instantiate an amount of currency.
     * 
     * @param string $name ISO-4217 currency code.
     * @param array $arguments 
     * @return Money
     */
    public static function __callStatic(string $name, array $arguments) : Money
    {
        $class = __NAMESPACE__ . '\\ISO4217\\' . strtoupper($name);
        $value = count($arguments) ? reset($arguments) : 0;

        if (class_exists($class)) {
            return new $class($value);
        }

        $msg = 'The given value "' . $name . '" is not a valid ISO-4217 currency.';
        throw new UnexpectedValueException($msg, $value, $name);
    }

    /**
     * @param string $value Numeric currency value.
     * @param ParserInterface $parser|null Custom number parser implementation.
     * @return self
     * @throws UnexpectedValueException Invalid value format.
     */
    protected function __construct($value, ParserInterface $parser = null)
    {
        if (! $value instanceof BigDecimal) {
            $value = $this->getParser($parser)->parse($value);
        }

        $this->units = $value;
    }

    /**
     * If no explicit parser is used, default to a fraction-restricted decimal
     * number parser.
     * 
     * @param ParserInterface|null $parser 
     * @return ParserInterface
     */
    protected function getParser(ParserInterface $parser = null) : ParserInterface
    {
        if ($parser) {
            return $parser;
        }

        $precision = $this->getPrecision();

        if (is_int($precision)) {
            return new DecimalParser($precision);
        } else {
            return new FloatParser();
        }
    }

    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        return (string) $this->getFormattedValue();
    }

    /**
     * Set scale of the output value to the precision defined in the currency.
     * 
     * @return BigDecimal
     */
    protected function getFormattedValue() : BigDecimal
    {
        $scale = $this->getPrecision();

        return $scale === null ? $this->units : $this->units->toScale($scale);
    }

    /**
     * Helper method for testing whether two money objects are compatible.
     * 
     * @param Money $money 
     * @return boolean
     */
    public function matches(Money $money) : bool
    {
        return $money->getCurrency() === $this->getCurrency();
    }

    /**
     * Check if two money objects represent the same value.
     * 
     * @param Money $money 
     * @return boolean
     */
    public function equals(Money $money) : bool
    {
        if (! $this->matches($money)) {
            return false;
        }

        return $this->units->isEqualTo($money->units);
    }

    /**
     * Add two money objects together.
     * 
     * @param Money $money 
     * @return Money
     */
    public function add(Money $money) : Money
    {
        if ($this->matches($money)) {
            $result = $this->units->plus($money->units);
            return new static($result);
        }

        $tpl = 'It is not possible to add %s to %s.';
        $msg = sprintf($tpl, $money->getName(), $this->getName());
        throw new InvalidCurrencyException($msg, $money);
    }

    /**
     * Subtract two money objects.
     * 
     * @param Money $money 
     * @return Money
     */
    public function subtract(Money $money) : Money
    {
        if ($this->matches($money)) {
            $result = $this->units->minus($money->units);
            return new static($result);
        }

        $tpl = 'It is not possible to subtract %s from %s.';
        $msg = sprintf($tpl, $money->getName(), $this->getName());
        throw new InvalidCurrencyException($msg, $money);
    }
}
