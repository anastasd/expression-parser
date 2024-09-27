<?php

namespace AnastasD\ExpressionParser\Evaluators\EvaluatorHelpers;

use AnastasD\ExpressionParser\Evaluators\EvaluatorHelpers\EvaluatorHelper as EvaluatorHelper;

use AnastasD\ExpressionParser\Exceptions\EvaluationException as EvaluationException;

class EvaluatorHelperDefault extends EvaluatorHelper
{
    /* #region Operators */
    public function add(array $args)
    {
        return $args[0] + $args[1];
    }

    public function divide(array $args)
    {
        if (0 === $args[1]) {
            throw new \Exception('Division by zero');
        } else {
            return $args[0] / $args[1];
        }
    }

    public function multiply(array $args)
    {
        return $args[0] * $args[1];
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
    
    public function exp(array $args)
    {
        return exp($args[0]);
    }
    
    public function floor(array $args)
    {
        return floor($args[0]);
    }
    
    public function log(array $args)
    {
        if (0 < count($args)) {
            return log($args[0], $args[1]);
        } else {
            return log($args[0], M_E);
        }
    }
    
    public function log10(array $args)
    {
        return log10($args[0]);
    }
    
    public function max(array $args)
    {
        return max($args);
    }
    
    public function min(array $args)
    {
        return min($args);
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
    
    public function round(array $args)
    {
        if (0 < count($args)) {
            return round($args[0], $args[1]);
        } else {
            return round($args[0], 0);
        }
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

    /* #endregion */
}