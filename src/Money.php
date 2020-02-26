<?php

namespace Dormilich\Money;

use const STR_PAD_LEFT;
use const STR_PAD_RIGHT;

use Dormilich\Money\Exception\UnexpectedValueException;

/**
 * This class represents monatary currencies with debit & credit functionality.
 */
abstract class Money extends Unit
{
    public function __construct(string $value)
    {
        $this->units = $this->parseValue($value);
    }

    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        $precision = $this->getPrecision();
        $patched = $this->stringifyValue();

        $parts[] = substr($patched, 0, -$precision);
        $parts[] = substr($patched, -$precision);

        $parts = array_filter($parts, 'strlen');
        $value = implode('.', $parts);

        return $value;
    }

    /**
     * Parses the input string and returns an integer representing the amount in
     * the minor unit.
     * 
     * @param string $value 
     * @return integer
     * @throws UnexpectedValueException
     */
    private function parseValue(string $value)
    {
        if (! $this->validateValue($value)) {
            $currency = $this->getCurrency();
            $msg = 'Invalid number format for currency ' . $currency . '.';
            throw new UnexpectedValueException($msg, $value, $currency);
        }

        list($major, $minor) = explode('.', $value, 2) + [1 => ''];

        $minor = $this->patchFraction($minor);

        return (int) ($major . $minor);
    }

    /**
     * Test whether the numeric value corresponds to the currency's expected format.
     * 
     * @param string $value 
     * @return boolean
     */
    private function validateValue(string $value) : bool
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
        $precision = $this->getPrecision();

        $regexp = '[+\-]?\d+';

        if ($precision > 0) {
            $regexp .= sprintf('(\.\d{1,%d})?', $precision);
        }

        return '~^' . $regexp . '$~';
    }

    /**
     * Pad the fraction value to the required number of digits.
     * 
     * @param string $value 
     * @return string
     */
    private function patchFraction(string $value) : string
    {
        $precision = $this->getPrecision();

        return str_pad($value, $precision, '0', STR_PAD_RIGHT);
    }

    /**
     * Create a value string so that at least one digit of the major unit exists.
     * 
     * @return string
     */
    private function stringifyValue() : string
    {
        $precision = $this->getPrecision();
        $absolute = (string) abs($this->units);

        $value  = $this->units < 0 ? '-' : '';
        $value .= str_pad($absolute, $precision + 1, '0', STR_PAD_LEFT);

        return $value;
    }
}
