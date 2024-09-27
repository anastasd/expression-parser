<?php

namespace AnastasD\ExpressionParser\Evaluators\EvaluatorHelpers;

abstract class EvaluatorHelper
{
    public array $custom;

    public function setExpression(string $name, callable $callback)
    {
        $this->custom[$name] = $callback;
    }

    public function removeExpression(string $name)
    {
        unset($this->custom[$name]);
    }

    public function __call(string $name, array $args)
    {
        return $this->custom[$name]($args[0]);
    }
}