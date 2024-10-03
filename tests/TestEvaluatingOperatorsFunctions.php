<?php

use PHPUnit\Framework\TestCase;

use AnastasD\ExpressionParser\Settings;
use AnastasD\ExpressionParser\Parser;

class TestEvaluatingOperatorsFunctions extends TestCase
{
    /**
     * A test that adds a binary operator with a symbol '$' that returns the first argument and has a 4 order of execution
     * @return void
     */
    public function testAddingOperator()
    {
        $settings = new Settings(Settings::DEFAULT );

        $settings->setOperator(
            '$',
            'binary',
            4,
            'returnFirstArg',
            function ($args) {
                return "$args[0]";
            },
            'returnFirstArg',
            function ($args) {
                return $args[0];
            }
        );

        $parser = new Parser($settings);

        $input = ' -4 $5';

        $output = $parser->parse($input)
            ->prepare()
            ->evaluate([]);

        $this->assertEquals(-4, $output);
    }


    /**
     * A test that replaces the behaviour of operator '+' by multiplying the arguments instead of summing them
     * @return void
     */
    public function testChangingOperator()
    {
        $settings = new Settings(Settings::DEFAULT );

        $settings->setOperator(
            '+',
            'binary',
            2,
            'returnFirstArg',
            function ($args) {
                return "$args[0]*$args[1]";
            },
            'returnFirstArg',
            function ($args) {
                return $args[0] * $args[1];
            }
        );

        $parser = new Parser($settings);

        $input = ' -4 *5';

        $output = $parser->parse($input)
            ->prepare()
            ->evaluate([]);

        $this->assertEquals(-20, $output);
    }


    /**
     * A test that adds a function with name 'first' that returns the first argument and takes between 2 and 4 arguments
     * @return void
     */
    public function testAddingFunction()
    {
        $settings = new Settings(Settings::DEFAULT );

        $settings->setFunction(
            'first',
            2,
            4,
            'returnFirstArg',
            function ($args) {
                return "$args[0]";
            },
            'returnFirstArg',
            function ($args) {
                return $args[0];
            }
        );

        $parser = new Parser($settings);

        $input = ' -first(4, $a,$b)';

        $output = $parser->parse($input, ['$a', '$b'])
            ->prepare()
            ->evaluate([2, 3]);

        $this->assertEquals(-4, $output);
    }


    /**
     * A test that adds a function with name 'first' that returns the first argument and takes between 2 and 4 arguments
     * @return void
     */
    public function testChangingFunction()
    {
        $settings = new Settings(Settings::DEFAULT );

        $settings->setFunction(
            'pow',
            2,
            2,
            'returnFirstArg',
            function ($args) {
                return "($args[0]+$args[1])";
            },
            'returnFirstArg',
            function ($args) {
                return $args[0] + $args[1];
            }
        );

        $parser = new Parser($settings);

        $input = ' pow(4, $a)';

        $output = $parser->parse($input, ['$a'])
            ->prepare()
            ->evaluate([3.14]);

        $this->assertEquals(7.14, $output);
    }
}