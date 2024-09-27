<?php

namespace AnastasD\ExpressionParser\Validators;

use AnastasD\ExpressionParser\Exceptions\ParsingException as ParsingException;
use AnastasD\ExpressionParser\Exceptions\EvaluationException as EvaluationException;

use \AnastasD\ExpressionParser\Mappers\Mapper as Mapper;

class Validator
{
    static function checkBalancedBrackets(string $input, array $bracketPairs): void
    {
        foreach ($bracketPairs as $key => $value) {
            if (substr_count($input, $key) !== substr_count($input, $value)) {
                throw new ParsingException('Unbalanced brackets "' . $value . '"', $input);
            }
        }
    }

    static function checkFunctionArgsCount(array $nodesList, Mapper $mapper): void
    {
        foreach ($nodesList as $item) {
            if ("function" === $item["type"]) {
                $paramsCount = !array_key_exists("params", $item) ? 0 : count($item["params"]);
                $minArgs = $mapper::$functions[$item["name"]]["min_args"];
                $maxArgs = $mapper::$functions[$item["name"]]["max_args"];

                if (
                    $paramsCount < $minArgs
                    || $paramsCount > $maxArgs
                ) {
                    if ($minArgs === $maxArgs) {
                        $errorMessage = "Number of arguments for function \"" . $item["name"] . "\" must be " . $minArgs;
                    } else {
                        $errorMessage = "Number of arguments for function \"" . $item["name"] . "\" must be between " . $minArgs . " and " . $maxArgs;
                    }

                    throw new EvaluationException($errorMessage);
                }
            }
        }
    }
}