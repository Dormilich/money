<?php

namespace Dormilich\Money\ISO4217;

use Dormilich\Money\Money;

/**
 * @link https://www.currency-iso.org (2018-08-29)
 */
class XXX extends Money
{
    /**
     * Returns the 3-letter alphabetical currency code.
     * 
     * @return string
     */
    public function getCurrency() : string
    {
        return 'XXX';
    }

    /**
     * Returns the name of the currency.
     * 
     * @return string
     */
    public function getName() : string
    {
        return 'The codes assigned for transactions where no currency is involved';
    }

    /**
     * Returns the 3-digit numerical currency code.
     * 
     * @return string
     */
    public function getCode() : string
    {
        return '999';
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
        return null;
    }
}
