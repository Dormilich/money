<?php

namespace Dormilich\Money\Exception;

use Dormilich\Money\Money;
use Dormilich\Money\MoneyException;

/**
 * Exception thrown when an operation between different currencies is attempted.
 */
class InvalidCurrencyException extends \InvalidArgumentException implements MoneyException
{
    /**
     * @var Money
     */
    private $money;

    /**
     * @param string $message Error message.
     * @param Money $money The currency object causing the exception.
     * @return self
     */
    public function __construct(string $message, Money $money)
    {
        $this->money = $money;

        parent::__construct($message);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency() : string
    {
        return $this->money->getCurrency();
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->money->getValue();
    }
}
