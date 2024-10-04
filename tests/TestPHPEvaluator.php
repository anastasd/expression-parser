<?php

use PHPUnit\Framework\TestCase;

use AnastasD\ExpressionParser\Settings;
use AnastasD\ExpressionParser\Parser;


class TestPHPEvaluator extends TestCase
{
    public function testBasicPHPEvaluator()
    {
        $settings = new Settings(Settings::PHP);
        $parser = new Parser($settings);

        $input = '3+ 2';

        $output = $parser->parse($input)
            ->prepare()
            ->evaluate([]);

        $this->assertEquals(5, $output);
    }

    public function testFunctionsPHPEvaluator()
    {
        $settings = new Settings(Settings::PHP);
        $parser = new Parser($settings);

        $input = '- round(pow(3,$a- floor(6 /$b)), 4)';

        $output = $parser->parse($input, ['$a', '$b'])
            ->prepare()
            ->evaluate([2.7172, 3.1416]);

        $this->assertEquals(-6.5965, $output);
    }
}