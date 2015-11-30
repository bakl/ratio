<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 27.11.15
 */

namespace Ratio\ParametersParser;

use Ratio\ParametersParserInterface;

class ParametersParserByString implements ParametersParserInterface
{
    /**
     * @param mixed $n
     * @param mixed $m
     * @return array
     * @throws ParametersParserException
     */
    public function parse($n, $m = null)
    {
        if (!is_string($n)) {
            throw new ParametersParserException('expected string');
        }

        $re = <<<RE
{
    (?>
        # Only integer number
        ^
            ([\+\-]?)    # 1
            \s?
            ([0-9]+)     # 2
        $
    )
      |
    (?>
        # Full fraction
        ^
            ([\+\-]?)    # 3
            \s?
            ([0-9]+)     # 4
            \s?
            [\:\/\%]{1}
            \s?
            ([0-9]+)     # 5
        $
    )
      |
    (?>
        # Decimals
        ^
            ([\+\-]?)    # 6
            \s?
            ([0-9]+)     # 7
            \.
            ([0-9]+)     # 8
        $
    )
}Dx
RE;
        preg_match($re, $n, $matches);

        if (!isset($matches[0])) {
            throw new ParametersParserException('incorrect number (string)');
        }

        $denominator = 1;
        if (strlen($matches[2])) {
            $numerator = intval($matches[2]);
        } elseif (strlen($matches[4])) {
            $numerator = intval($matches[4]);
            $denominator = intval($matches[5]);
        } else {
            $numerator = intval($matches[7].$matches[8]);
            $denominator = pow(10, strlen($matches[8]));
        }

        if (in_array('-', $matches)) {
            $numerator = -1 * $numerator;
        }

        return [$numerator, $denominator];
    }
}