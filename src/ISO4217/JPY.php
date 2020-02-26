<?php

namespace Dormilich\Money\ISO4217;

use Dormilich\Money\Money;

/**
 * @link https://www.currency-iso.org (2018-08-29)
 */
class JPY extends Money
{
    /**
     * Returns the 3-letter alphabetical currency code.
     * 
     * @return string
     */
    public function getCurrency() : string
    {
        return 'JPY';
    }

    /**
     * Returns the name of the currency.
     * 
     * @return string
     */
    public function getName() : string
    {
        return 'Yen';
    }

    /**
     * Returns the 3-digit numerical currency code.
     * 
     * @return string
     */
    public function getCode() : string
    {
        return '392';
    }

    /**
     * Returns the number of digits after the decimal separator.
     * 
     * Note: Returns NULL for pseudo-currencies like precious metals.
     * 
     * @return integer|null
     */
    public function getPrecision() : ?int
    {
        return 0;
    }
}
