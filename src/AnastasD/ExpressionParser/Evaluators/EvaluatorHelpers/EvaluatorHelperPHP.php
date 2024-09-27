<?php

namespace AnastasD\ExpressionParser\Evaluators\EvaluatorHelpers;

use AnastasD\ExpressionParser\Evaluators\EvaluatorHelpers\EvaluatorHelper as EvaluatorHelper;

use AnastasD\ExpressionParser\Exceptions\EvaluationException as EvaluationException;

class EvaluatorHelperPHP extends EvaluatorHelper
{
    /* #region Operators */
    public function add(array $args)
    {
        return $args[0] + $args[1];
    }

    public function divide(array $args)
    {
        if (0 === $args[1]) {
            throw new EvaluationException('Division by zero');
        } else {
            return $args[0] / $args[1];
        }
    }

    public function modulus(array $args)
    {
        return $args[0] % $args[1];
    }

    public function multiply(array $args)
    {
        return $args[0] * $args[1];
    }

    public function power(array $args)
    {
        return $args[0] ** $args[1];
    }

    public function subtract(array $args)
    {
        return $args[0] - $args[1];
    }

    /* #endregion */

    /* #region Functions */
    public function abs(array $args)
    {
        return abs($args[0]);
    }

    public function acos(array $args)
    {
        return acos($args[0]);
    }

    public function acosh(array $args)
    {
        return acosh($args[0]);
    }

    public function asin(array $args)
    {
        return asin($args[0]);
    }

    public function asinh(array $args)
    {
        return asinh($args[0]);
    }

    public function atan(array $args)
    {
        return atan($args[0]);
    }

    public function atan2(array $args)
    {
        return atan2($args[0], $args[1]);
    }

    public function atanh(array $args)
    {
        return atanh($args[0]);
    }

    public function base_convert(array $args)
    {
        return base_convert($args[0], $args[1], $args[2]);
    }

    public function bindec(array $args)
    {
        return bindec($args[0]);
    }

    public function ceil(array $args)
    {
        return ceil($args[0]);
    }

    public function cos(array $args)
    {
        return cos($args[0]);
    }

    public function cosh(array $args)
    {
        return cosh($args[0]);
    }

    public function decbin(array $args)
    {
        return decbin($args[0]);
    }

    public function dechex(array $args)
    {
        return dechex($args[0]);
    }

    public function decoct(array $args)
    {
        return decoct($args[0]);
    }

    public function deg2rad(array $args)
    {
        return deg2rad($args[0]);
    }

    public function exp(array $args)
    {
        return exp($args[0]);
    }

    public function expm1(array $args)
    {
        return expm1($args[0]);
    }

    public function floor(array $args)
    {
        return floor($args[0]);
    }

    public function fmod(array $args)
    {
        return fmod($args[0], $args[1]);
    }

    public function hexdec(array $args)
    {
        return hexdec($args[0]);
    }

    public function hypot(array $args)
    {
        return hypot($args[0], $args[1]);
    }

    public function intdiv(array $args)
    {
        return intdiv($args[0], $args[1]);
    }

    public function is_finite(array $args)
    {
        return is_finite($args[0]);
    }

    public function is_infinite(array $args)
    {
        return is_infinite($args[0]);
    }

    public function is_nan(array $args)
    {
        return is_nan($args[0]);
    }

    public function lcg_value()
    {
        return lcg_value();
    }

    public function log(array $args)
    {
        if (1 < count($args)) {
            return log($args[0], $args[1]);
        } else {
            return log($args[0], M_E);
        }
    }

    public function log10(array $args)
    {
        return log10($args[0]);
    }

    public function log1p(array $args)
    {
        return log1p($args[0]);
    }

    public function max(array $args)
    {
        return max($args);
    }

    public function min(array $args)
    {
        return min($args);
    }

    public function octdec(array $args)
    {
        return octdec($args[0]);
    }

    public function pi()
    {
        return pi();
    }

    public function pow(array $args)
    {
        return pow($args[0], $args[1]);
    }

    public function rand(array $args)
    {
        $param0 = 0;
        $param1 = getrandmax();

        if (array_key_exists(0, $args)) {
            $param0 = $args[0];
        }

        if (array_key_exists(1, $args)) {
            $param1 = $args[1];
        }
        
        return rand($param0, $param1);
    }

    public function rad2deg(array $args)
    {
        return rad2deg($args[0]);
    }

    public function round(array $args)
    {
        return count($args) === 2 ? round($args[0], $args[1]) : round($args[0], 0);
    }

    public function sin(array $args)
    {
        return sin($args[0]);
    }

    public function sinh(array $args)
    {
        return sinh($args[0]);
    }

    public function srand(array $args)
    {
        srand($args[0]);
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

    /* #endregion */
}