<?php

namespace Dormilich\Money\Parser;

use Brick\Math\BigDecimal;
use Dormilich\Money\Exception\UnexpectedValueException;

class MoneyParser implements ParserInterface
{
    /**
     * @var integer
     */
    private $precision = 0;

    public function __construct(int $precision)
    {
        $this->precision = $precision;
    }

    /**
     * @inheritDoc
     */
    public function parse($value) : BigDecimal
    {
        if ($this->validate($value)) {
            return BigDecimal::of($value)->toScale($this->precision);
        }

        $msg = 'Invalid number format encountered.';
        throw new UnexpectedValueException($msg, $value, '');
    }

    /**
     * Test whether the numeric value corresponds to the currency's expected format.
     * 
     * @param string $value 
     * @return boolean
     */
    private function validate(string $value) : bool
    {
        $regexp = $this->getValidationExpression();

        return (bool) preg_match($regexp, $value);
    }

    /**
     * Returns the regular expression for the currency's expected format.
     * 
     * @return string
     */
    private function getValidationExpression() : string
    {
        $regexp = '[+\-]?\d+';

        if ($this->precision > 0) {
            $regexp .= sprintf('(\.\d{1,%d})?', $this->precision);
        }

        return '~^' . $regexp . '$~';
    }
}
