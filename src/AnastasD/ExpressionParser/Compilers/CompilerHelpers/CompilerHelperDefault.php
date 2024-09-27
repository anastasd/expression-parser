<?php

namespace AnastasD\ExpressionParser\Compilers\CompilerHelpers;

class CompilerHelperDefault extends CompilerHelper
{
    public function add(array $args)
    {
        return "$args[0]+$args[1]";
    }

    public function subtract(array $args)
    {
        return "$args[0]-$args[1]";
    }

    public function multiply(array $args)
    {
        return "$args[0]*$args[1]";
    }

    public function divide(array $args)
    {
        if (0 === $args[1]) {
            throw new \Exception('Division by zero');
        } else {
            return "$args[0]/$args[1]";
        }
    }

    /* Functions */
    public function abs(array $args)
    {
        return "abs($args[0])";
    }

    public function acos(array $args)
    {
        return "acos($args[0])";
    }

    public function acosh(array $args)
    {
        return "acosh($args[0])";
    }

    public function asin(array $args)
    {
        return "asin($args[0])";
    }

    public function asinh(array $args)
    {
        return "asinh($args[0])";
    }

    public function atan(array $args)
    {
        return "atan($args[0])";
    }

    public function atan2(array $args)
    {
        return "atan2($args[0], $args[1])";
    }

    public function atanh(array $args)
    {
        return "atanh($args[0])";
    }

    public function ceil(array $args)
    {
        return "ceil($args[0])";
    }

    public function cos(array $args)
    {
        return "cos($args[0])";
    }

    public function cosh(array $args)
    {
        return "cosh($args[0])";
    }

    public function exp(array $args)
    {
        return "exp($args[0])";
    }

    public function floor(array $args)
    {
        return "floor($args[0])";
    }

    public function log(array $args)
    {
        if(0 < count($args)) {
            return "log($args[0], $args[1])";
        } else {
            return "log($args[0], M_E)";
        }
    }

    public function log10(array $args)
    {
        return "log10($args[0])";
    }

    public function max(array $args)
    {
        return "max(" . implode(",", $args) . ")";
    }

    public function min(array $args)
    {
        return "min(" . implode(",", $args) . ")";
    }

    public function pi()
    {
        return M_PI;
    }

    public function pow(array $args)
    {
        return "pow($args[0], $args[1])";
    }

    public function rand(array $args)
    {
        return "rand($args[0] ?? 0, $args[1] ?? getrandmax())";
    }

    public function round(array $args)
    {
        return "round($args[0], $args[1] ?? 0)";
    }

    public function sin(array $args)
    {
        return sin($args[0]);
    }

    public function sinh(array $args)
    {
        return sinh($args[0]);
    }

    public function sqrt(array $args)
    {
        return sqrt($args[0]);
    }

    public function tan(array $args)
    {
        return tan($args[0]);
    }

    public function tanh(array $args)
    {
        return tanh($args[0]);
    }
}