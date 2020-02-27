<?php

namespace Dormilich\Money;

use Brick\Math\BigDecimal;
use Dormilich\Money\Exception\UnexpectedValueException;
use Dormilich\Money\Parser\DecimalParser;
use Dormilich\Money\Parser\FloatParser;
use Dormilich\Money\Parser\ParserInterface;

/**
 * This class represents monatary currencies with debit & credit functionality.
 */
abstract class Money implements Currency
{
    /**
     * @var BigDecimal
     */
    private $units;

    /**
     * Instantiate an amount of currency.
     * 
     * @param string $name ISO-4217 currency code.
     * @param array $arguments 
     * @return Money
     */
    public static function __callStatic(string $name, array $arguments) : Money
    {
        $class = __NAMESPACE__ . '\\ISO4217\\' . strtoupper($name);
        $value = count($arguments) ? reset($arguments) : 0;

        if (class_exists($class)) {
            return new $class($value);
        }

        $msg = 'The given value "' . $name . '" is not a valid ISO-4217 currency.';
        throw new UnexpectedValueException($msg, $value, $name);
    }

    /**
     * @param string $value Numeric currency value.
     * @param ParserInterface $parser|null Custom number parser implementation.
     * @return self
     * @throws UnexpectedValueException Invalid value format.
     */
    protected function __construct($value, ParserInterface $parser = null)
    {
        $this->units = $this->getParser($parser)->parse($value);
    }

    /**
     * If no explicit parser is used, default to a fraction-restricted decimal
     * number parser.
     * 
     * @param ParserInterface|null $parser 
     * @return ParserInterface
     */
    protected function getParser(ParserInterface $parser = null) : ParserInterface
    {
        if ($parser) {
            return $parser;
        }

        $precision = $this->getPrecision();

        if (is_int($precision)) {
            return new DecimalParser($precision);
        } else {
            return new FloatParser();
        }
    }

    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        return (string) $this->getFormattedValue();
    }

    /**
     * Set scale of the output value to the precision defined in the currency.
     * 
     * @return BigDecimal
     */
    protected function getFormattedValue() : BigDecimal
    {
        $scale = $this->getPrecision();

        return $scale === null ? $this->units : $this->units->toScale($scale);
    }
}
