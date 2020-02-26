<?php

namespace Dormilich\Money;

use const STR_PAD_LEFT;
use const STR_PAD_RIGHT;

use Dormilich\Money\Exception\UnexpectedValueException;
use Dormilich\Money\Parser\MoneyParser;

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
        $parser = new MoneyParser($this->getPrecision());
        $this->units = $parser->parse($value);
    }
}
