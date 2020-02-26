<?php

namespace Dormilich\Money;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;

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

    public function __construct($value)
    {
        try {
            $this->units = BigDecimal::of(rtrim($value, '0'));
        } catch (MathException $e) {
            throw new UnexpectedValueException($e->getMessage(), $value, $this->getCurrency());
        }
    }

    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        return (string) $this->units;
    }
}
