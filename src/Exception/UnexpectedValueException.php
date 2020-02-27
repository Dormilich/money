<?php

namespace Dormilich\Money\Exception;

use Dormilich\Money\MoneyException;

/**
 * Exception thrown when an object instantiation failed.
 */
class UnexpectedValueException extends \UnexpectedValueException implements MoneyException
{
    /**
     * @var string
     */
    private $currency;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $message Error message.
     * @param mixed $value The invalid value.
     * @param string $currency 
     * @return self
     */
    public function __construct(string $message, $value, string $currency)
    {
        $this->currency = $currency;
        $this->value = $value;

        parent::__construct($message);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->value;
    }
}
