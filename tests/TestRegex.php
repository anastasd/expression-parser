<?php

use PHPUnit\Framework\TestCase;

use AnastasD\ExpressionParser\Settings;
use AnastasD\ExpressionParser\Parser;


class TestRegex extends TestCase
{
    public function testFunctionRegex()
    {
        $settings = new Settings(Settings::PHP);

        $settings->setVariableRegex('/^\$\w+$/');

        $parser = new Parser($settings);

        $input = '$a+ $b ';

        $output = $parser->parse($input)
            ->prepare()
            ->compile([]);

        $this->assertEquals('function expressionResult( $a,$b ){ $param_0_0=($a+$b); return $param_0_0 ;}', $output);
    }

    public function testFunctionsPHPEvaluator()
    {
        $settings = new Settings(Settings::PHP);

        $settings->setFunctionRegex('/^\w+$/');

        $parser = new Parser($settings);

        $input = '- blah(mlah(3,$a- hrah(6 /$b)), 4)';

        $parser->parse($input, ['$a', '$b'])
            ->prepare();

        echo json_encode($parser->getNodeList());

        $this->assertEquals(-6.5965, $output);
    }
}