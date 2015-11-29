<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 27.11.15
 */

namespace Ratio;

interface ParametersParserInterface
{
    /**
     * @param mixed $n
     * @param mixed $m
     * @return array
     */
    public function parse($n, $m = null);
}