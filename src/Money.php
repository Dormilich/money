<?php

namespace Dormilich\Money;

use const STR_PAD_LEFT;
use const STR_PAD_RIGHT;

use Dormilich\Money\Parser\MoneyParser;
use Dormilich\Money\Parser\ParserInterface;

/**
 * This class represents monatary currencies with debit & credit functionality.
 */
abstract class Money extends Unit
{
    /**
     * @inheritDoc
     */
    public function getValue() : string
    {
        return (string) $this->units->toScale($this->getPrecision());
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
        if (! $parser) {
            $parser = new MoneyParser($this->getPrecision());
        }

        return $parser;
    }
}
