<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 27.11.15
 */

namespace Ratio\ParametersParser;

use Ratio\ParametersParserInterface;

class ParametersParserByArray implements ParametersParserInterface
{
    /**
     * @param mixed $n
     * @param mixed $m
     * @return array
     * @throws ParametersParserException
     */
    public function parse($n, $m = null)
    {
        if (!is_array($n)) {
            throw new ParametersParserException('array expected');
        }

        if (empty($n)) {
            throw new ParametersParserException('empty array');
        }

        if (!isset($n[1])) {
            $n[1] = 1;
        }

        if (!is_int($n[0]) or !is_int($n[1])) {
            throw new ParametersParserException('incorrect array');
        }

        return $n;
    }
}