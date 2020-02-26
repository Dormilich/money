<?php

namespace Dormilich\Money;

use Brick\Math\BigDecimal;
use Dormilich\Money\Parser\UnitParser;

/**
 * Unit of Measure. Does not support debit & credit functionality.
 * This is used for Funds, precious metals, etc.
 */
abstract class Unit implements Currency
{
    /**
     * @var BigDecimal
     */
    protected $units;

    /**
     * @param string $value Numeric currency value.
     * @return self
     * @throws UnexpectedValueException Invalid value format.
     */
    public function __construct($value)
    {
        $parser = new UnitParser();
        $this->units = $parser->parse($value);
    }

    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        return (string) $this->units;
    }
}
