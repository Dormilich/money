<?php

namespace Dormilich\Money\Parser;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Dormilich\Money\Parser\UnitParser;

/**
 * Parse a float string into an integer object.
 */
class UnitParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse($value) : BigDecimal
    {
        try {
            return BigDecimal::of(rtrim($value, '0'));
        } catch (MathException $e) {
            throw new UnexpectedValueException($e->getMessage(), $value, '');
        }
    }
}
