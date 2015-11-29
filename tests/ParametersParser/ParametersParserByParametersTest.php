<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 28.11.15
 */

namespace Ratio\Tests\ParametersParser;

use Ratio\ParametersParser\ParametersParserByParameters;

class ParametersParserByParametersTest extends \PHPUnit_Framework_TestCase
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
        $pp = new ParametersParserByParameters();
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
        $pp = new ParametersParserByParameters();
        $pp->parse($n, $m);
    }

    public function dataProvider_TestParse_IncorrectParams()
    {
        return [
            ['no int', 1],
            [1, 'no int'],
        ];
    }

    public function dataProvider_TestParse_CorrectParams()
    {
        return [
            [1, 2, [1, 2]],
            [3, null, [3, 1]],
        ];
    }
}
