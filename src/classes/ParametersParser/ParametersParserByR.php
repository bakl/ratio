<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 27.11.15
 */

namespace Ratio\ParametersParser;

use Ratio\ParametersParserInterface;
use Ratio\R;

class ParametersParserByR implements ParametersParserInterface
{
    /**
     * @param mixed $n
     * @param mixed $m
     * @return array
     * @throws ParametersParserException
     */
    public function parse($n, $m = null)
    {
        if ($n instanceof R) {
            return [$n->getNumerator(), $n->getDenominator()];
        }

        throw new ParametersParserException('expected instanceof R');
    }
}