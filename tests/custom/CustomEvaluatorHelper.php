<?php

class CustomEvaluatorHelper extends AnastasD\ExpressionParser\Evaluators\EvaluatorHelpers\EvaluatorHelper
{
    public function eucl(array $args)
    {
        if (0 === $args[1]) {
            throw new AnastasD\ExpressionParser\Exceptions\CompilationException('Division by zero');
        } else {
            return floor($args[0] / $args[1]);
        }
    }

    public function xor(array $args)
    {
        return $args[0] ^ $args[1];
    }
}