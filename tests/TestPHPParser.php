<?php

use PHPUnit\Framework\TestCase;

use AnastasD\ExpressionParser\Settings;
use AnastasD\ExpressionParser\Parser;

class TestPHPParser extends TestCase
{
    public function testBasicPHPCompilator()
    {
        $settings = new Settings(Settings::PHP);
        $parser = new Parser($settings);

        $input = '3+ 2';

        $output = $parser->parse($input)
            ->prepare()
            ->compile();

        $this->assertEquals('function expressionResult(  ){ $param_0_0=(3+2); return $param_0_0 ;}', $output);
    }

    public function testFunctionsPHPCompilator()
    {
        $settings = new Settings(Settings::PHP);
        $parser = new Parser($settings);

        $input = 'pow(3,$a- floor(6 /$b))';

        $output = $parser->parse($input, ['$a', '$b'])
            ->prepare()
            ->compile([]);

        $this->assertEquals('function expressionResult( $a,$b ){ $param_2=3;$param_5_0=6/$b;$param_5=$param_5_0;$param_4=floor($param_5);$param_3_0=($a-$param_4);$param_3=$param_3_0;$param_1=pow($param_2, $param_3); return $param_1 ;}', $output);
    }

    public function testCompressionPHPCompilator()
    {
        $settings = new Settings(Settings::PHP);
        $parser = new Parser($settings);

        $input = 'pow(3,$a- floor(6 /$b))';

        $output = $parser->parse($input, ['$a', '$b'])
            ->prepare()
            ->compile(["compress"]);

        $this->assertEquals('function expressionResult( $a,$b ){ return pow(3, ($a-floor(6/$b))) ;}', $output);
    }

    public function testTemplatePHPCompilator()
    {
        $settings = new Settings(Settings::PHP);
        $settings->setCompressedTemplate('{{FUNCTION_RESULT}}');

        $parser = new Parser($settings);

        $input = 'pow(3,$a- floor(6 /$b))';

        $output = $parser->parse($input, ['$a', '$b'])
            ->prepare()
            ->compile(["compress"]);

        $this->assertEquals('pow(3, ($a-floor(6/$b)))', $output);
    }
}