<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 28.11.15
 */

namespace Ratio\Tests\ParametersParser;

use Ratio\ParametersParser\ParametersParserByR;
use Ratio\R;

class ParametersParserByRTest extends \PHPUnit_Framework_TestCase
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
        $pp = new ParametersParserByR();
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
        $pp = new ParametersParserByR();
        $pp->parse($n, $m);
    }

    public function dataProvider_TestParse_IncorrectParams()
    {
        return [
            ['no R', null],
            ['no R', 'ignore parameter'],
        ];
    }

    public function dataProvider_TestParse_CorrectParams()
    {
        return [
            [new R(1, 2), null, [1, 2]],
            [new R(2, 3), 'ignore parameter', [2, 3]],
        ];
    }
}
