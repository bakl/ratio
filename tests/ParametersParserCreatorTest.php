<?php
/**
 * @author: Denis Akulov <akulov.d.g@gmail.com>
 * @since: 28.11.15
 */

namespace Ratio\Tests;

use Ratio\ParametersParser\ParametersParserByArray;
use Ratio\ParametersParser\ParametersParserByParameters;
use Ratio\ParametersParser\ParametersParserByR;
use Ratio\ParametersParser\ParametersParserByString;
use Ratio\ParametersParserCreator;
use Ratio\R;

class ParametersParserCreatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate_Array () {
        $ppc = new ParametersParserCreator();
        $this->assertTrue($ppc->create(['by array']) instanceof ParametersParserByArray);
    }

    public function testCreate_String () {
        $ppc = new ParametersParserCreator();
        $this->assertTrue($ppc->create('by string') instanceof ParametersParserByString);
    }

    public function testCreate_R () {
        $ppc = new ParametersParserCreator();
        $this->assertTrue($ppc->create(new R(1,2)) instanceof ParametersParserByR);
    }

    public function testCreate_Params () {
        $ppc = new ParametersParserCreator();
        $this->assertTrue($ppc->create(1) instanceof ParametersParserByParameters);
    }
}
