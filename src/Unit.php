<?php

namespace Dormilich\Money;

use Brick\Math\BigDecimal;
use Dormilich\Money\Parser\ParserInterface;
use Dormilich\Money\Parser\UnitParser;

/**
 * Unit of Measure. Does not support debit & credit functionality.
 * This is used for Funds, precious metals, etc.
 */
abstract class Unit implements Currency
{
    /**
     * @var BigDecimal
     */
    protected $units;

    /**
     * @param string $value Numeric currency value.
     * @param ParserInterface $parser|null Custom number parser implementation.
     * @return self
     * @throws UnexpectedValueException Invalid value format.
     */
    public function __construct($value, ParserInterface $parser = null)
    {
        $this->units = $this->getParser($parser)->parse($value);
    }

    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        return (string) $this->units;
    }

    /**
     * If no explicit parser is used, default to a general decimal number parser.
     * 
     * @param ParserInterface|null $parser 
     * @return ParserInterface
     */
    protected function getParser(ParserInterface $parser = null) : ParserInterface
    {
        if (! $parser) {
            $parser = new UnitParser();
        }

        return $parser;
    }
}
