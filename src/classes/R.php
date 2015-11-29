<?php
/**
 * R::io -> Rational numbers
 *
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 24.11.15
 */

namespace Ratio;

class R
{
    /**
     * The numerator.
     *
     * @var int
     */
    private $numerator;

    /**
     * The denominator. Must not be zero.
     *
     * @var int
     */
    private $denominator;

    /**
     * R constructor.
     * @param int $numerator
     * @param int $denominator
     * @throws DivisionByZeroException
     * @throws NumberFormatException
     */
    public function __construct($numerator, $denominator)
    {
        $this->setNumerator($numerator);
        $this->setDenominator($denominator);
    }

    /**
     * @param mixed $n
     * @param int $m
     * @return R
     * @throws NumberFormatException
     */
    public static function io($n, $m = null)
    {
        $ppCreator = new ParametersParserCreator();
        $pp = $ppCreator->create($n, $m);

        $result = $pp->parse($n, $m);
        return new R($result[0], $result[1]);
    }

    /**
     * (1/2;2/3) -> (3/6;4/6)
     *
     * @param $a
     * @param $b
     * @return void
     */
    public static function commonDenominator(R &$a, R &$b)
    {
        if ($a->getDenominator() != $b->getDenominator()) {
            $g = self::_gcd($a->getDenominator(), $b->getDenominator());
            $adg = $a->getDenominator() / $g;
            $bdg = $b->getDenominator() / $g;

            $a->setNumerator($a->getNumerator() * $bdg);
            $a->setDenominator($a->getDenominator() * $bdg);
            $b->setNumerator($b->getNumerator() * $adg);
            $b->setDenominator($b->getDenominator() * $adg);
        }
    }

    /**
     * @return int
     */
    public function getNumerator()
    {
        return $this->numerator;
    }

    /**
     * @return int
     */
    public function getDenominator()
    {
        return $this->denominator;
    }

    /**
     * @param int $numerator
     * @throws IntegerOverflowException
     * @throws NumberFormatException
     */
    private function setNumerator($numerator)
    {
        if (is_float($numerator) && ($numerator >= (PHP_INT_MAX + 1) || $numerator <= (-PHP_INT_MAX - 2))) {
            throw new IntegerOverflowException('numerator integer overflow');
        }

        if (!is_int($numerator)) {
            throw new NumberFormatException('incorrect numerator');
        }

        $this->numerator = $numerator;
    }

    /**
     * @param int $denominator
     * @throws DivisionByZeroException
     * @throws IntegerOverflowException
     * @throws NumberFormatException
     */
    private function setDenominator($denominator)
    {
        if (is_float($denominator) && ($denominator >= (PHP_INT_MAX + 1) || $denominator <= (-PHP_INT_MAX - 2))) {
            throw new IntegerOverflowException('numerator integer overflow');
        }

        if (!is_int($denominator)) {
            throw new NumberFormatException('incorrect denominator');
        }

        if ($denominator < 0) {
            throw new NumberFormatException('incorrect denominator (less that 0)');
        }

        if (intval($denominator) === 0) {
            throw new DivisionByZeroException('denominator is initialized by zero');
        }

        $this->denominator = $denominator;
    }

    /**
     * 5/2 -> 2/1
     *
     * @return R
     */
    public function getIntegerPart()
    {
        if ($this->getNumerator() >= 0) {
            return new R((int)floor($this->getNumerator() / $this->getDenominator()), 1);
        } else {
            return new R((int)ceil($this->getNumerator() / $this->getDenominator()), 1);
        }
    }

    /**
     * 5/2 -> 1/2
     *
     * @return R
     */
    public function getFractionPart()
    {
        return $this->minus($this->getIntegerPart());
    }

    /**
     * @return int
     */
    public function gcd()
    {
        $a = abs($this->getNumerator());
        $b = abs($this->getDenominator());
        return self::_gcd($a, $b);
    }

    /**
     * @return void
     */
    public function simplifying()
    {
        $gcd = $this->gcd();
        $this->setNumerator($this->getNumerator() / $gcd);
        $this->setDenominator($this->getDenominator() / $gcd);
    }

    /**
     * @param $n
     * @param null $m
     * @return R
     */
    public function plus($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        self::commonDenominator($a, $b);

        $a->setNumerator($a->getNumerator() + $b->getNumerator());
        $a->simplifying();

        return $a;
    }

    /**
     * @param $n
     * @param null $m
     * @return R
     */
    public function minus($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        self::commonDenominator($a, $b);

        $a->setNumerator($a->getNumerator() - $b->getNumerator());
        $a->simplifying();

        return $a;
    }

    /**
     * @param $n
     * @param null $m
     * @return R
     */
    public function multipliedBy($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        $a->setNumerator($a->getNumerator() * $b->getNumerator());
        $a->setDenominator($a->getDenominator() * $b->getDenominator());

        $a->simplifying();

        return $a;
    }

    /**
     * @param $n
     * @param null $m
     * @return R
     * @throws DivisionByZeroException
     */
    public function dividedBy($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        if ($b->getNumerator() == 0) {
            throw new DivisionByZeroException();
        }

        $a->setNumerator($a->getNumerator() * $b->getDenominator());
        $a->setDenominator($a->getDenominator() * $b->getNumerator());

        $a->simplifying();

        return $a;
    }

    /**
     * @param $n
     * @return R
     * @throws NumberFormatException
     */
    public function pow($n)
    {
        if (!is_int($n)) {
            throw new NumberFormatException('expected integer value');
        }

        $a = clone $this;

        $a->setNumerator(pow($a->getNumerator(), $n));
        $a->setDenominator(pow($a->getDenominator(), $n));

        return $a;
    }

    /**
     * @param $n
     * @param null $m
     * @return bool
     */
    public function equalTo($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        self::commonDenominator($a, $b);

        if ($a->getNumerator() === $b->getNumerator()) {
            return true;
        }

        return false;
    }

    /**
     * @param $n
     * @param null $m
     * @return bool
     */
    public function lessThan($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        self::commonDenominator($a, $b);

        if ($a->getNumerator() < $b->getNumerator()) {
            return true;
        }

        return false;
    }

    /**
     * @param $n
     * @param null $m
     * @return bool
     */
    public function greaterThan($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        self::commonDenominator($a, $b);

        if ($a->getNumerator() > $b->getNumerator()) {
            return true;
        }

        return false;
    }

    /**
     * @param $n
     * @param null $m
     * @return bool
     */
    public function lessOrEqualThan($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        self::commonDenominator($a, $b);

        if ($a->getNumerator() <= $b->getNumerator()) {
            return true;
        }

        return false;
    }

    /**
     * @param $n
     * @param null $m
     * @return bool
     */
    public function greaterOrEqualThan($n, $m = null)
    {
        $a = clone $this;
        $b = R::io($n, $m);

        self::commonDenominator($a, $b);

        if ($a->getNumerator() >= $b->getNumerator()) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->getNumerator()}/{$this->getDenominator()}";
    }

    /**
     * @param $a
     * @param $b
     * @return number
     */
    private static function _gcd($a, $b)
    {
        while ($b != 0) {
            $r = $a % $b;
            $a = $b;
            $b = $r;
        }

        return $a;
    }

}