<?php

namespace AnastasD\ExpressionParser\Mappers;

class MapperPHP extends Mapper
{
    static $operators = [
        '+' => [
            'arity' => 'binary',
            'order' => 0,
            'evaluate' => 'add',
            'compile' => 'add'
        ],
        '-' => [
            'arity' => 'binary',
            'order' => 0,
            'evaluate' => 'subtract',
            'compile' => 'subtract'
        ],
        '*' => [
            'arity' => 'binary',
            'order' => 1,
            'evaluate' => 'multiply',
            'compile' => 'multiply'
        ],
        '**' => [
            'arity' => 'binary',
            'order' => 2,
            'evaluate' => 'power',
            'compile' => 'power'
        ],
        '%' => [
            'arity' => 'binary',
            'order' => 2,
            'evaluate' => 'modulus',
            'compile' => 'modulus'
        ],
        '/' => [
            'arity' => 'binary',
            'order' => 1,
            'evaluate' => 'divide',
            'compile' => 'divide'
        ]
    ];

    static $functions = [
        'abs' => [
            'evaluate' => 'abs',
            'compile' => 'abs',
            'min_args' => 1,
            'max_args' => 1
        ],
        'acos' => [
            'evaluate' => 'acos',
            'compile' => 'acos',
            'min_args' => 1,
            'max_args' => 1
        ],
        'acosh' => [
            'evaluate' => 'acosh',
            'compile' => 'acosh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'asin' => [
            'evaluate' => 'asin',
            'compile' => 'asin',
            'min_args' => 1,
            'max_args' => 1
        ],
        'asinh' => [
            'evaluate' => 'asinh',
            'compile' => 'asinh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'atan' => [
            'evaluate' => 'atan',
            'compile' => 'atan',
            'min_args' => 1,
            'max_args' => 1
        ],
        'atan2' => [
            'evaluate' => 'atan2',
            'compile' => 'atan2',
            'min_args' => 2,
            'max_args' => 2
        ],
        'atanh' => [
            'evaluate' => 'atanh',
            'compile' => 'atanh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'base_convert' => [
            'evaluate' => 'base_convert',
            'compile' => 'base_convert',
            'min_args' => 3,
            'max_args' => 3
        ],
        'bindec' => [
            'evaluate' => 'bindec',
            'compile' => 'bindec',
            'min_args' => 1,
            'max_args' => 1
        ],
        'ceil' => [
            'evaluate' => 'ceil',
            'compile' => 'ceil',
            'min_args' => 1,
            'max_args' => 1
        ],
        'cos' => [
            'evaluate' => 'cos',
            'compile' => 'cos',
            'min_args' => 1,
            'max_args' => 1
        ],
        'cosh' => [
            'evaluate' => 'cosh',
            'compile' => 'cosh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'decbin' => [
            'evaluate' => 'decbin',
            'compile' => 'decbin',
            'min_args' => 1,
            'max_args' => 1
        ],
        'dechex' => [
            'evaluate' => 'dechex',
            'compile' => 'dechex',
            'min_args' => 1,
            'max_args' => 1
        ],
        'decoct' => [
            'evaluate' => 'decoct',
            'compile' => 'decoct',
            'min_args' => 1,
            'max_args' => 1
        ],
        'deg2rad' => [
            'evaluate' => 'deg2rad',
            'compile' => 'deg2rad',
            'min_args' => 1,
            'max_args' => 1
        ],
        'exp' => [
            'evaluate' => 'exp',
            'compile' => 'exp',
            'min_args' => 1,
            'max_args' => 1
        ],
        'expm1' => [
            'evaluate' => 'expm1',
            'compile' => 'expm1',
            'min_args' => 1,
            'max_args' => 1
        ],
        'floor' => [
            'evaluate' => 'floor',
            'compile' => 'floor',
            'min_args' => 1,
            'max_args' => 1
        ],
        'fmod' => [
            'evaluate' => 'fmod',
            'compile' => 'fmod',
            'min_args' => 1,
            'max_args' => 1
        ],
        'hexdec' => [
            'evaluate' => 'hexdec',
            'compile' => 'hexdec',
            'min_args' => 1,
            'max_args' => 1
        ],
        'hypot' => [
            'evaluate' => 'hypot',
            'compile' => 'hypot',
            'min_args' => 2,
            'max_args' => 2
        ],
        'intdiv' => [
            'evaluate' => 'intdiv',
            'compile' => 'intdiv',
            'min_args' => 2,
            'max_args' => 2
        ],
        'is_finite' => [
            'evaluate' => 'is_finite',
            'compile' => 'is_finite',
            'min_args' => 1,
            'max_args' => 1
        ],
        'is_infinite' => [
            'evaluate' => 'is_infinite',
            'compile' => 'is_infinite',
            'min_args' => 1,
            'max_args' => 1
        ],
        'is_nan' => [
            'evaluate' => 'is_nan',
            'compile' => 'is_nan',
            'min_args' => 1,
            'max_args' => 1
        ],
        'lcg_value' => [
            'evaluate' => 'lcg_value',
            'compile' => 'lcg_value',
            'min_args' => 0,
            'max_args' => 0
        ],
        'log' => [
            'evaluate' => 'log',
            'compile' => 'log',
            'min_args' => 1,
            'max_args' => 2
        ],
        'log10' => [
            'evaluate' => 'log10',
            'compile' => 'log10',
            'min_args' => 1,
            'max_args' => 1
        ],
        'log1p' => [
            'evaluate' => 'log1p',
            'compile' => 'log1p',
            'min_args' => 1,
            'max_args' => 1
        ],
        'max' => [
            'evaluate' => 'max',
            'compile' => 'max',
            'min_args' => 1,
            'max_args' => PHP_INT_MAX
        ],
        'min' => [
            'evaluate' => 'min',
            'compile' => 'min',
            'min_args' => 1,
            'max_args' => PHP_INT_MAX
        ],
        'octdec' => [
            'evaluate' => 'octdec',
            'compile' => 'octdec',
            'min_args' => 1,
            'max_args' => 1
        ],
        'pi' => [
            'evaluate' => 'pi',
            'compile' => 'pi',
            'min_args' => 0,
            'max_args' => 0
        ],
        'pow' => [
            'evaluate' => 'pow',
            'compile' => 'pow',
            'min_args' => 2,
            'max_args' => 2
        ],
        'rand' => [
            'evaluate' => 'rand',
            'compile' => 'rand',
            'min_args' => 0,
            'max_args' => 2
        ],
        'rad2deg' => [
            'evaluate' => 'rad2deg',
            'compile' => 'rad2deg',
            'min_args' => 1,
            'max_args' => 1
        ],
        'round' => [
            'evaluate' => 'round',
            'compile' => 'round',
            'min_args' => 1,
            'max_args' => 2
        ],
        'sin' => [
            'evaluate' => 'sin',
            'compile' => 'sin',
            'min_args' => 1,
            'max_args' => 1
        ],
        'sinh' => [
            'evaluate' => 'sinh',
            'compile' => 'sinh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'srand' => [
            'evaluate' => 'srand',
            'compile' => 'srand',
            'min_args' => 1,
            'max_args' => 1
        ],
        'sqrt' => [
            'evaluate' => 'sqrt',
            'compile' => 'sqrt',
            'min_args' => 1,
            'max_args' => 1
        ],
        'tan' => [
            'evaluate' => 'tan',
            'compile' => 'tan',
            'min_args' => 1,
            'max_args' => 1
        ],
        'tanh' => [
            'evaluate' => 'tanh',
            'compile' => 'tanh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'trunc' => [
            'evaluate' => 'trunc',
            'compile' => 'trunc',
            'min_args' => 1,
            'max_args' => 1
        ]
    ];

    static $brackets = [['(', ')']];
    static $parameterSeparators = [',', ';'];
    static $quotemarks = ['"', '\''];
}