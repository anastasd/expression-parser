<?php

namespace AnastasD\ExpressionParser\Mappers;

class MapperJavaScript extends Mapper
{
    static $operators = [
        '+' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 0,
            'evaluate' => 'add',
            'compile' => 'add'
        ],
        '-' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 0,
            'evaluate' => 'subtract',
            'compile' => 'subtract'
        ],
        '*' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 1,
            'evaluate' => 'multiply',
            'compile' => 'multiply'
        ],
        '**' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 2,
            'evaluate' => 'power',
            'compile' => 'power'
        ],
        '%' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 0,
            'evaluate' => 'modulus',
            'compile' => 'modulus'
        ],
        '/' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 1,
            'evaluate' => 'divide',
            'compile' => 'divide'
        ]
    ];

    static $functions = [
        'Math.abs' => [
            'custom' => false,
            'evaluate' => 'abs',
            'compile' => 'abs',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.acos' => [
            'custom' => false,
            'evaluate' => 'acos',
            'compile' => 'acos',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.acosh' => [
            'custom' => false,
            'evaluate' => 'acosh',
            'compile' => 'acosh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.asin' => [
            'custom' => false,
            'evaluate' => 'asin',
            'compile' => 'asin',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.asinh' => [
            'custom' => false,
            'evaluate' => 'asinh',
            'compile' => 'asinh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.atan' => [
            'custom' => false,
            'evaluate' => 'atan',
            'compile' => 'atan',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.atan2' => [
            'custom' => false,
            'evaluate' => 'atan2',
            'compile' => 'atan2',
            'min_args' => 2,
            'max_args' => 2
        ],
        'Math.atanh' => [
            'custom' => false,
            'evaluate' => 'atanh',
            'compile' => 'atanh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.cbrt' => [
            'custom' => false,
            'evaluate' => 'cbrt',
            'compile' => 'cbrt',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.ceil' => [
            'custom' => false,
            'evaluate' => 'ceil',
            'compile' => 'ceil',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.clz32' => [
            'custom' => false,
            'evaluate' => 'clz32',
            'compile' => 'clz32',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.cos' => [
            'custom' => false,
            'evaluate' => 'cos',
            'compile' => 'cos',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.cosh' => [
            'custom' => false,
            'evaluate' => 'cosh',
            'compile' => 'cosh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.exp' => [
            'custom' => false,
            'evaluate' => 'exp',
            'compile' => 'exp',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.expm1' => [
            'custom' => false,
            'evaluate' => 'expm1',
            'compile' => 'expm1',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.floor' => [
            'custom' => false,
            'evaluate' => 'floor',
            'compile' => 'floor',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.f16round' => [
            'custom' => false,
            'evaluate' => 'f16round',
            'compile' => 'f16round',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.fround' => [
            'custom' => false,
            'evaluate' => 'fround',
            'compile' => 'fround',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.hypot' => [
            'custom' => false,
            'evaluate' => 'hypot',
            'compile' => 'hypot',
            'min_args' => 2,
            'max_args' => 2
        ],
        'Math.imul' => [
            'custom' => false,
            'evaluate' => 'imul',
            'compile' => 'imul',
            'min_args' => 2,
            'max_args' => 2
        ],
        'Math.log' => [
            'custom' => false,
            'evaluate' => 'log',
            'compile' => 'log',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.log10' => [
            'custom' => false,
            'evaluate' => 'log10',
            'compile' => 'log10',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.log1p' => [
            'custom' => false,
            'evaluate' => 'log1p',
            'compile' => 'log1p',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.log2' => [
            'custom' => false,
            'evaluate' => 'log2',
            'compile' => 'log2',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.max' => [
            'custom' => false,
            'evaluate' => 'max',
            'compile' => 'max',
            'min_args' => 1,
            'max_args' => PHP_INT_MAX
        ],
        'Math.min' => [
            'custom' => false,
            'evaluate' => 'min',
            'compile' => 'min',
            'min_args' => 1,
            'max_args' => PHP_INT_MAX
        ],
        'Math.pow' => [
            'custom' => false,
            'evaluate' => 'pow',
            'compile' => 'pow',
            'min_args' => 2,
            'max_args' => 2
        ],
        'Math.random' => [
            'custom' => false,
            'evaluate' => 'rand',
            'compile' => 'rand',
            'min_args' => 0,
            'max_args' => 0
        ],
        'Math.round' => [
            'custom' => false,
            'evaluate' => 'round',
            'compile' => 'round',
            'min_args' => 0,
            'max_args' => 0
        ],
        'Math.sign' => [
            'custom' => false,
            'evaluate' => 'sign',
            'compile' => 'sign',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.sin' => [
            'custom' => false,
            'evaluate' => 'sin',
            'compile' => 'sin',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.sinh' => [
            'custom' => false,
            'evaluate' => 'sinh',
            'compile' => 'sinh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.sqrt' => [
            'custom' => false,
            'evaluate' => 'sqrt',
            'compile' => 'sqrt',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.tan' => [
            'custom' => false,
            'evaluate' => 'tan',
            'compile' => 'tan',
            'min_args' => 1,
            'max_args' => 1
        ],
        'Math.tanh' => [
            'custom' => false,
            'evaluate' => 'tanh',
            'compile' => 'tanh',
            'min_args' => 1,
            'max_args' => 1
        ]
    ];

    static $brackets = [['(', ')']];
    static $parameterSeparators = [','];
    static $quotemarks = ['"', '\''];
}