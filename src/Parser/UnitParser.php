<?php

namespace Dormilich\Money\Parser;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Dormilich\Money\Parser\UnitParser;
use Dormilich\Money\Exception\UnexpectedValueException;

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
            $trimmed = $this->trim($value);
            return BigDecimal::of($trimmed);
        } catch (MathException $e) {
            throw new UnexpectedValueException($e->getMessage(), $value, '');
        }
    }

    /**
     * Remove trailing zeros on the fractional part, if any.
     * 
     * @param string $value 
     * @return string
     */
    private function trim($value)
    {
        if (strpos($value, '.') !== false) {
            $value = rtrim($value, '0');
            $value = rtrim($value, '.');
        }

        return $value;
    }
}
