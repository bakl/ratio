<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 28.11.15
 */

namespace Ratio\Tests\ParametersParser;

use Ratio\ParametersParser\ParametersParserByString;

class ParametersParserByStringTest extends \PHPUnit_Framework_TestCase
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
        $pp = new ParametersParserByString();
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
        $pp = new ParametersParserByString();
        $pp->parse($n, $m);
    }

    public function dataProvider_TestParse_IncorrectParams()
    {
        return [
            [['No string value'], null],
            ['', null],
            ['1:', null],
            [':2', null],
            ['+  1:2', null],
        ];
    }

    public function dataProvider_TestParse_CorrectParams()
    {
        return [
            ['1', null, [1, 1]],
            ['1 : 2', null, [1, 2]],
            ['2 / 3', null, [2, 3]],
            ['3 % 4', null, [3, 4]],
            ['1:2', null, [1, 2]],
            ['2/3', null, [2, 3]],
            ['3%4', null, [3, 4]],
            ['03%04', null, [3, 4]],
            ['103%104', null, [103, 104]],
            ['1.5', null, [15, 10]],
            ['13.55', null, [1355, 100]],
            ['-13.55', null, [-1355, 100]],
            ['+13.55', null, [1355, 100]],
            ['-13', null, [-13, 1]],
            ['+13', null, [13, 1]],
            ['- 1 : 2', null, [-1, 2]],
            ['- 2 / 3', null, [-2, 3]],
            ['- 3 % 4', null, [-3, 4]],
            ['+ 1 : 2', null, [1, 2]],
            ['+ 2 / 3', null, [2, 3]],
            ['+ 3 % 4', null, [3, 4]],
            ['+ 3 % 4', 'ignore parameter', [3, 4]],
        ];
    }
}
