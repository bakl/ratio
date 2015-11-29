<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 27.11.15
 */

namespace Ratio;

use Ratio\ParametersParser\ParametersParserByArray;
use Ratio\ParametersParser\ParametersParserByParameters;
use Ratio\ParametersParser\ParametersParserByR;
use Ratio\ParametersParser\ParametersParserByString;

class ParametersParserCreator
{
    /**
     * @param mixed $n
     * @return ParametersParserInterface
     */
    public function create($n)
    {
        if (is_array($n)) {
            return new ParametersParserByArray();
        }

        if (is_string($n)) {
            return new ParametersParserByString();
        }

        if ($n instanceof R) {
            return new ParametersParserByR();
        }

        return new ParametersParserByParameters();
    }

}