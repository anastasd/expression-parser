<?php

namespace AnastasD\ExpressionParser\Compilers\CompilerHelpers;

class CompilerHelperJavaScript extends CompilerHelper
{
    /* #region Operators */

    static function add(array $args)
    {
        return "$args[0]+$args[1]";
    }

    public function divide(array $args)
    {
        if (0 === $args[1]) {
            throw new \Exception('Division by zero');
        } else {
            return "$args[0]/$args[1]";
        }
    }

    public function modulus(array $args)
    {
        return "$args[0]%$args[1]";
    }

    public function multiply(array $args)
    {
        return "$args[0]*$args[1]";
    }

    public function power(array $args)
    {
        return "$args[0]**$args[1]";
    }

    public function subtract(array $args)
    {
        return "$args[0]-$args[1]";
    }

    /* #endregion */

    /* #region Functions */

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

    public function cbrt(array $args)
    {
        if (0 > $args[0]) {
            return "(-pow(-$args[0], 1/3))";
        } else {
            return "pow($args[0], 1/3)";
        }
    }

    public function ceil(array $args)
    {
        return "ceil($args[0])";
    }

    public function clz32(array $args)
    {
        return "($args[0] === 0 ? 32 : 31 - floor(log($args[0] | 0xFFFFFFFF, 2)))";
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

    public function expm1(array $args)
    {
        return "(exp($args[0]) - 1)";
    }

    public function floor(array $args)
    {
        return "floor($args[0])";
    }

    public function f16round(array $args)
    {
        return "(round($args[0] * 2048) / 2048)";
    }

    public function fround(array $args)
    {
        return "((float) sprintf('%.7f', $args[0]))";
    }

    public function hypot(array $args)
    {
        return "hypot($args[0], $args[1])";
    }

    public function imul(array $args)
    {
        return "((($args[0] & 0xFFFFFFFF) * ($args[1] & 0xFFFFFFFF)) | 0)";
    }

    public function log(array $args)
    {
        if (0 < count($args)) {
            return "log($args[0], $args[1])";
        } else {
            return "log($args[0], M_E)";
        }
    }

    public function log10(array $args)
    {
        return "log10($args[0])";
    }

    public function log1p(array $args)
    {
        return " log(1 + $args[0])";
    }

    public function log2(array $args)
    {
        return " log($args[0], 2)";
    }

    public function max(array $args)
    {
        return "max(" . implode(",", $args) . ")";
    }

    public function min(array $args)
    {
        return "min(" . implode(",", $args) . ")";
    }

    public function pow(array $args)
    {
        return "pow($args[0], $args[1])";
    }

    public function random()
    {
        return "(mt_rand() / mt_getrandmax())";
    }

    public function round(array $args)
    {
        return "round($args[0], 0)";
    }

    public function sign(array $args)
    {
        return "(($args[0] > 0) - ($args[0] < 0))";
    }

    public function sin(array $args)
    {
        return "sin($args[0])";
    }

    public function sinh(array $args)
    {
        return "sinh($args[0])";
    }

    public function sqrt(array $args)
    {
        return "sqrt($args[0])";
    }

    public function tan(array $args)
    {
        return "tan($args[0])";
    }

    public function tanh(array $args)
    {
        return "tanh($args[0])";
    }

    public function trunc(array $args)
    {
        return "($args[0] < 0 ? ceil($args[0]) : floor($args[0]))";
    }

    /* #endregion */
}