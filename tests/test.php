<?php

include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Settings.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Parser.php';

include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Mappers/Mapper.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Mappers/MapperPHP.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Evaluators/Evaluator.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Evaluators/EvaluatorPHP.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Evaluators/EvaluatorHelpers/EvaluatorHelper.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Evaluators/EvaluatorHelpers/EvaluatorHelperPHP.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Compilers/Compiler.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Compilers/CompilerPHP.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Compilers/CompilerHelpers/CompilerHelper.php';
include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Compilers/CompilerHelpers/CompilerHelperPHP.php';

include_once __DIR__ . '/../src/AnastasD/ExpressionParser/Validators/Validator.php';


use AnastasD\ExpressionParser\Settings;
use AnastasD\ExpressionParser\Parser;


class TestRegex
{
    public function testVariableRegex()
    {
        $settings = new Settings(Settings::PHP);

        $parser = new Parser($settings);

        $input = '$period+1';

        $output = $parser->parse($input, ['$period'])
            ->prepare()
            ->compile(["compress"]);

            echo $output;
    }
}

$t = new TestRegex();
$t->testVariableRegex();