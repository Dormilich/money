<?php

namespace Dormilich\Money\Parser;

use Brick\Math\BigDecimal;
use Dormilich\Money\Exception\UnexpectedValueException;

/**
 * Parse a number into a BigDecimal object.
 */
interface ParserInterface
{
    /**
     * Parses input into a BigNumber instance. Must throw an exception if the
     * input is not acceptable.
     * 
     * @param mixed $value 
     * @return BigDecimal
     * @throws UnexpectedValueException
     */
    public function parse($value) : BigDecimal;
}
