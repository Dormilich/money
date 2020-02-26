<?php

use Dormilich\Money\Unit;
use Dormilich\Money\ISO4217\XXX; // no currency
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Dormilich\Money\Unit
 */
class SetupUnitTest extends TestCase
{
    public function unitProvider()
    {
        return [
            [53, '53'],
            [-53, '-53'],
            [53.2, '53.2'],
            [-53.2, '-53.2'],
            [53.20, '53.2'],
            [-53.20, '-53.2'],
            ['50', '50'],
            ['53.0', '53'],
            ['53.20', '53.2'],
            ['+53.20', '53.2'],
            ['-53.20', '-53.2'],
        ];
    }

    /**
     * @dataProvider unitProvider
     */
    public function testCreateUnitObject($in, $out)
    {
        $unit = new XXX($in);

        $this->assertInstanceOf(Unit::class, $unit);
        $this->assertSame('XXX', $unit->getCurrency());
        $this->assertSame($out, $unit->getValue());
    }
}
