<?php

namespace Dormilich\Money;

interface MoneyException
{
    /**
     * The alphabetical currency code.
     * 
     * @return string
     */
    public function getCurrency() : string;

    /**
     * The value invoved in the failure.
     * 
     * @return mixed
     */
    public function getValue();
}
