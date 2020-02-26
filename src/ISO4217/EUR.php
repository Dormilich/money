<?php

namespace Dormilich\Money\ISO4217;

use Dormilich\Money\Money;

/**
 * @link https://www.currency-iso.org (2018-08-29)
 */
class EUR extends Money
{
    /**
     * Returns the 3-letter alphabetical currency code.
     * 
     * @return string
     */
    public function getCurrency() : string
    {
        return 'EUR';
    }

    /**
     * Returns the name of the currency.
     * 
     * @return string
     */
    public function getName() : string
    {
        return 'Euro';
    }

    /**
     * Returns the 3-digit numerical currency code.
     * 
     * @return string
     */
    public function getCode() : string
    {
        return '978';
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
        return 2;
    }
}
