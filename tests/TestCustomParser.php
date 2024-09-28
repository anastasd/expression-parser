<?php

include_once __DIR__ . '/custom/CustomMapper.php';
include_once __DIR__ . '/custom/CustomCompiler.php';
include_once __DIR__ . '/custom/CustomEvaluator.php';
include_once __DIR__ . '/custom/CustomCompilerHelper.php';
include_once __DIR__ . '/custom/CustomEvaluatorHelper.php';

use PHPUnit\Framework\TestCase;

use AnastasD\ExpressionParser\Settings;
use AnastasD\ExpressionParser\Parser;

class TestCustomParser extends TestCase
{
    public function testCustomCompilator()
    {
        $customMapper = new CustomMapper;
        $customCompilerHelper = new CustomCompilerHelper;
        $testEvaluatorHelper = new CustomEvaluatorHelper;

        $customCompiler = new CustomCompiler($customMapper, $customCompilerHelper);
        $customEvaluator = new CustomEvaluator($customMapper, $testEvaluatorHelper);

        $settings = new Settings(
            Settings::CUSTOM,
            [
                "evaluator" => $customEvaluator,
                "compiler" => $customCompiler
            ]
        );
        $settings->setCompressedTemplate('{{FUNCTION_RESULT}}');

        $parser = new Parser($settings);

        $input = '$a\ xor(5,$b)';

        $output = $parser->parse($input, ['$a', '$b'])
            ->prepare()
            ->compile(["compress"]);

        $this->assertEquals('floor($a/(5^$b))', $output);
    }

    public function testCustomEvaluator()
    {
        $customMapper = new CustomMapper;
        $customCompilerHelper = new CustomCompilerHelper;
        $testEvaluatorHelper = new CustomEvaluatorHelper;

        $customCompiler = new CustomCompiler($customMapper, $customCompilerHelper);
        $customEvaluator = new CustomEvaluator($customMapper, $testEvaluatorHelper);

        $settings = new Settings(
            Settings::CUSTOM,
            [
                "evaluator" => $customEvaluator,
                "compiler" => $customCompiler
            ]
        );
        $settings->setCompressedTemplate('{{FUNCTION_RESULT}}');

        $parser = new Parser($settings);

        $input = '$a\ xor(5,$b)';

        $output = $parser->parse($input, ['$a', '$b'])
            ->prepare()
            ->compile(["compress"]);

        $this->assertEquals('floor($a/(5^$b))', $output);
    }
}