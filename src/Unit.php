<?php

namespace Dormilich\Money;

/**
 * Unit of Measure. Does not support debit & credit functionality.
 * This is used for Funds, precious metals, etc.
 */
abstract class Unit implements Currency
{
    /**
     * @var integer|float
     */
    protected $units;

    public function __construct(float $value)
    {
        $this->units = $value;
    }

    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        return (string) $this->units;
    }
}
