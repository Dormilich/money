<?php

namespace Dormilich\Money;

use const STR_PAD_LEFT;
use const STR_PAD_RIGHT;

use Brick\Math\Exception\MathException;
use Dormilich\Money\Exception\UnexpectedValueException;

/**
 * This class represents monatary currencies with debit & credit functionality.
 */
abstract class Money extends Unit
{
    /**
     * @param string $value Numeric currency value.
     * @return self
     * @throws UnexpectedValueException Invalid value format.
     */
    public function __construct(string $value)
    {
        try {
            $parser = new Parser($this->getPrecision());
            $this->units = $parser->parse($value);
        } catch (MathException $e) {
            throw new UnexpectedValueException($e->getMessage(), $value, $this->getCurrency());
        }
    }
}
