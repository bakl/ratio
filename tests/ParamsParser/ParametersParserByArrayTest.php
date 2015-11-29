<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 28.11.15
 */

namespace Ratio\Tests\ParametersParser;

use Ratio\ParametersParser\ParametersParserByArray;

class ParametersParserByArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $n
     * @param $m
     * @param $e
     * @throws \Ratio\ParametersParser\ParametersParserException
     * @dataProvider dataProvider_TestParse_CorrectParams
     */
    public function testParse_CorrectParams($n, $m, $e)
    {
        $pp = new ParametersParserByArray();
        $this->assertEquals($e, $pp->parse($n, $m));
    }

    /**
     * @param $n
     * @param $m
     * @throws \Ratio\ParametersParser\ParametersParserException
     * @expectedException \Ratio\ParametersParser\ParametersParserException
     * @dataProvider dataProvider_TestParse_IncorrectParams
     */
    public function testParse_IncorrectParams($n, $m)
    {
        $pp = new ParametersParserByArray();
        $pp->parse($n, $m);
    }

    public function dataProvider_TestParse_IncorrectParams()
    {
        return [['no array', 1], [[], null], [['1', 2], null], [[1, '2'], null]];
    }

    public function dataProvider_TestParse_CorrectParams()
    {
        return [
            [[1, 2], null, [1, 2]],
            [[3, 4], 'ignore value', [3, 4]],
            [[3], null, [3, 1]],
        ];
    }
}
