<?php

class CustomCompilerHelper extends AnastasD\ExpressionParser\Compilers\CompilerHelpers\CompilerHelper
{
    public function eucl(array $args)
    {
        if (0 === $args[1]) {
            throw new AnastasD\ExpressionParser\Exceptions\CompilationException('Division by zero');
        } else {
            return "floor($args[0]/$args[1])";
        }
    }

    public function xor(array $args)
    {
        return "($args[0]^$args[1])";
    }
}