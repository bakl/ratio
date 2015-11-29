<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 27.11.15
 */

namespace Ratio\ParametersParser;

use Ratio\ParametersParserInterface;

class ParametersParserByParameters implements ParametersParserInterface
{
    /**
     * @param mixed $n
     * @param mixed $m
     * @return array
     * @throws ParametersParserException
     */
    public function parse($n, $m = null)
    {
        if (empty($m)) {
            $m = 1;
        }

        if (!is_int($n) || !is_int($m)) {
            throw new ParametersParserException('incorrect params');
        }

        return [$n, $m];
    }
}