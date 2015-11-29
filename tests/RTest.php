<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 25.11.15
 */

namespace Ratio\Tests;

use Ratio\R;

class RTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct_CreateNewRationalNumber()
    {
        $n = new R(1, 2);
        $this->assertEquals(1, $n->getNumerator());
        $this->assertEquals(2, $n->getDenominator());
    }

    /**
     * @param $a
     * @param $b
     * @expectedException \Ratio\NumberFormatException
     * @dataProvider dataProvider_testConstruct_ExceptionNumberFormat
     */
    public function testConstruct_ExceptionNumberFormat($a, $b)
    {
        new R($a, $b);
    }

    /**
     * @expectedException \Ratio\DivisionByZeroException
     */
    public function testConstruct_ExceptionDivisionByZero()
    {
        new R(2, 0);
    }

    /**
     * @expectedException \Ratio\IntegerOverflowException
     * @dataProvider dataProvider_testConstruct_ExceptionIntegerOverflow
     * @param $n
     * @param $m
     */
    public function testConstruct_ExceptionIntegerOverflow($n, $m)
    {
        new R($n, $m);
    }

    public function testIo_Simple()
    {
        $n = R::io('1/2');
        $this->assertEquals(1, $n->getNumerator());
        $this->assertEquals(2, $n->getDenominator());
    }

    public function testGcd_Simple()
    {
        $n = new R(15, 10);
        $this->assertEquals(5, $n->gcd());
    }

    public function testToString_Simple()
    {
        $this->assertEquals("2/3", new R(2, 3));
        $this->assertEquals("-2/3", new R(-2, 3));
    }

    public function testPlus_NotOverwritten()
    {
        $a = new R(1, 2);
        $b = new R(2, 3);
        $c = $a->plus($b);
        $this->assertEquals(1, $a->getNumerator());
        $this->assertEquals(2, $a->getDenominator());
        $this->assertEquals(2, $b->getNumerator());
        $this->assertEquals(3, $b->getDenominator());
        $this->assertEquals(7, $c->getNumerator());
        $this->assertEquals(6, $c->getDenominator());
    }

    public function testPlus_ZeroResult()
    {
        $a = new R(-1, 2);
        $b = new R(1, 2);
        $x = $a->plus($b);
        $this->assertEquals(0, $x->getNumerator());
        $this->assertEquals(1, $x->getDenominator());
    }

    public function testMinus_NotOverwritten()
    {
        $a = new R(1, 2);
        $b = new R(2, 3);
        $c = $a->minus($b);
        $this->assertEquals(1, $a->getNumerator());
        $this->assertEquals(2, $a->getDenominator());
        $this->assertEquals(2, $b->getNumerator());
        $this->assertEquals(3, $b->getDenominator());
        $this->assertEquals(-1, $c->getNumerator());
        $this->assertEquals(6, $c->getDenominator());
    }

    public function testMinus_ZeroResult()
    {
        $a = new R(1, 2);
        $b = new R(1, 2);
        $x = $a->minus($b);
        $this->assertEquals(0, $x->getNumerator());
        $this->assertEquals(1, $x->getDenominator());
    }

    public function testMultipliedBy_NotOverwritten()
    {
        $a = new R(1, 2);
        $b = new R(2, 3);
        $c = $a->multipliedBy($b);
        $this->assertEquals(1, $a->getNumerator());
        $this->assertEquals(2, $a->getDenominator());
        $this->assertEquals(2, $b->getNumerator());
        $this->assertEquals(3, $b->getDenominator());
        $this->assertEquals(1, $c->getNumerator());
        $this->assertEquals(3, $c->getDenominator());
    }

    public function testMultipliedBy_ZeroResult()
    {
        $a = new R(1, 2);
        $b = new R(0, 1);
        $x = $a->multipliedBy($b);
        $this->assertEquals(0, $x->getNumerator());
        $this->assertEquals(1, $x->getDenominator());
    }

    public function testDividedBy_NotOverwritten()
    {
        $a = new R(1, 2);
        $b = new R(2, 3);
        $c = $a->dividedBy($b);
        $this->assertEquals(1, $a->getNumerator());
        $this->assertEquals(2, $a->getDenominator());
        $this->assertEquals(2, $b->getNumerator());
        $this->assertEquals(3, $b->getDenominator());
        $this->assertEquals(3, $c->getNumerator());
        $this->assertEquals(4, $c->getDenominator());
    }

    /**
     * @throws \Ratio\DivisionByZeroException
     * @expectedException \Ratio\DivisionByZeroException
     */
    public function testDividedBy_ZeroResult()
    {
        $a = new R(1, 2);
        $b = new R(0, 1);
        $x = $a->dividedBy($b);
        $this->assertEquals(0, $x->getNumerator());
        $this->assertEquals(1, $x->getDenominator());
    }

    public function testSimplifying_Simple()
    {
        $n = new R(336, 36);
        $n->simplifying();
        $this->assertEquals(28, $n->getNumerator());
        $this->assertEquals(3, $n->getDenominator());

        $n = new R(-336, 36);
        $n->simplifying();
        $this->assertEquals(-28, $n->getNumerator());
        $this->assertEquals(3, $n->getDenominator());
    }

    public function testGetIntegerPart_Simple()
    {
        $n = new R(5, 2);
        $m = $n->getIntegerPart();
        $this->assertEquals(2, $m->getNumerator());
        $this->assertEquals(1, $m->getDenominator());

        $n = new R(-5, 2);
        $m = $n->getIntegerPart();
        $this->assertEquals(-2, $m->getNumerator());
        $this->assertEquals(1, $m->getDenominator());
    }

    public function testGetFractionPart_Simple()
    {
        $n = new R(5, 2);
        $m = $n->getFractionPart();
        $this->assertEquals(1, $m->getNumerator());
        $this->assertEquals(2, $m->getDenominator());

        $n = new R(-5, 2);
        $m = $n->getFractionPart();
        $this->assertEquals(-1, $m->getNumerator());
        $this->assertEquals(2, $m->getDenominator());
    }

    public function testPow_Simple()
    {
        $n = new R(2, 3);
        $m = $n->pow(3);
        $this->assertEquals(2, $n->getNumerator());
        $this->assertEquals(3, $n->getDenominator());
        $this->assertEquals(8, $m->getNumerator());
        $this->assertEquals(27, $m->getDenominator());
    }

    /**
     * @expectedException \Ratio\NumberFormatException
     * @throws \Ratio\NumberFormatException
     */
    public function testPow_Exception()
    {
        $n = new R(2, 3);
        $n->pow(0.5);
    }

    public function testCommonDenominator_Simple()
    {
        $a = new R(1, 2);
        $b = new R(2, 3);
        R::commonDenominator($a, $b);

        $this->assertEquals(3, $a->getNumerator());
        $this->assertEquals(6, $a->getDenominator());
        $this->assertEquals(4, $b->getNumerator());
        $this->assertEquals(6, $b->getDenominator());
    }

    public function testEqualTo_Simple()
    {
        $a = new R(1, 2);
        $b = new R(1, 2);
        $this->assertTrue($a->equalTo($b));

        $a = new R(-1, 2);
        $b = new R(-1, 2);
        $this->assertTrue($a->equalTo($b));

        $a = new R(-1, 2);
        $b = new R(-1, 3);
        $this->assertFalse($a->equalTo($b));

        $a = new R(1, 2);
        $b = new R(2, 1);
        $this->assertFalse($a->equalTo($b));
    }

    public function testLessThan_Simple()
    {
        $a = new R(1, 2);
        $b = new R(1, 2);
        $this->assertFalse($a->lessThan($b));
        $this->assertFalse($b->lessThan($a));

        $a = new R(-1, 2);
        $b = new R(-1, 2);
        $this->assertFalse($a->lessThan($b));
        $this->assertFalse($b->lessThan($a));

        $a = new R(-1, 3);
        $b = new R(-1, 2);
        $this->assertFalse($a->lessThan($b));
        $this->assertTrue($b->lessThan($a));

        $a = new R(2, 1);
        $b = new R(1, 2);
        $this->assertFalse($a->lessThan($b));
        $this->assertTrue($b->lessThan($a));

    }

    public function testGreaterThan_Simple()
    {
        $a = new R(1, 2);
        $b = new R(1, 2);
        $this->assertFalse($a->greaterThan($b));
        $this->assertFalse($b->greaterThan($a));

        $a = new R(-1, 2);
        $b = new R(-1, 2);
        $this->assertFalse($a->greaterThan($b));
        $this->assertFalse($b->greaterThan($a));

        $a = new R(-1, 3);
        $b = new R(-1, 2);
        $this->assertTrue($a->greaterThan($b));
        $this->assertFalse($b->greaterThan($a));

        $a = new R(2, 1);
        $b = new R(1, 2);
        $this->assertTrue($a->greaterThan($b));
        $this->assertFalse($b->greaterThan($a));
    }

    public function testLessOrEqualThan_Simple()
    {
        $a = new R(1, 2);
        $b = new R(1, 2);
        $this->assertTrue($a->lessOrEqualThan($b));
        $this->assertTrue($b->lessOrEqualThan($a));

        $a = new R(-1, 2);
        $b = new R(-1, 2);
        $this->assertTrue($a->lessOrEqualThan($b));
        $this->assertTrue($b->lessOrEqualThan($a));

        $a = new R(-1, 3);
        $b = new R(-1, 2);
        $this->assertFalse($a->lessOrEqualThan($b));
        $this->assertTrue($b->lessOrEqualThan($a));

        $a = new R(2, 1);
        $b = new R(1, 2);
        $this->assertFalse($a->lessOrEqualThan($b));
        $this->assertTrue($b->lessOrEqualThan($a));
    }

    public function testGreaterOrEqualThan_Simple()
    {
        $a = new R(1, 2);
        $b = new R(1, 2);
        $this->assertTrue($a->greaterOrEqualThan($b));
        $this->assertTrue($b->greaterOrEqualThan($a));

        $a = new R(-1, 2);
        $b = new R(-1, 2);
        $this->assertTrue($a->greaterOrEqualThan($b));
        $this->assertTrue($b->greaterOrEqualThan($a));

        $a = new R(-1, 3);
        $b = new R(-1, 2);
        $this->assertTrue($a->greaterOrEqualThan($b));
        $this->assertFalse($b->greaterOrEqualThan($a));

        $a = new R(2, 1);
        $b = new R(1, 2);
        $this->assertTrue($a->greaterOrEqualThan($b));
        $this->assertFalse($b->greaterOrEqualThan($a));
    }

    public function dataProvider_testConstruct_ExceptionNumberFormat()
    {
        return [
            ['no int', 2], [2, 'no int'], [1, -2]
        ];
    }

    public function dataProvider_testConstruct_ExceptionIntegerOverflow()
    {
        return [
            [PHP_INT_MAX + 1, 1],
            [1, PHP_INT_MAX + 1],
            [-PHP_INT_MAX - 2, 1],
            [1, -PHP_INT_MAX - 2],
        ];
    }
}
