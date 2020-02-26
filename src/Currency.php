<?php

namespace Dormilich\Money;

interface Currency
{
    /**
     * Returns the formatted value according to the currency's numeric format.
     * 
     * @see http://php.net/number-format
     * @return string
     */
    public function getValue() : string;

    /**
     * Returns the 3-letter ISO-4217 currency code.
     * 
     * @return string
     */
    public function getCurrency() : string;

    /**
     * Returns the name of the currency.
     * 
     * @return string
     */
    public function getName() : string;

    /**
     * Returns the 3-digit numerical currency code.
     * 
     * @return string
     */
    public function getCode() : string;

    /**
     * Returns the number of digits after the decimal separator or NULL if no 
     * fixed precision applies.
     * 
     * @return integer|null
     */
    public function getPrecision() : ?int;
}
