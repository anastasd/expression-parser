<?php

namespace AnastasD\ExpressionParser\Mappers;

class MapperDefault extends Mapper
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
        '^' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 2,
            'evaluate' => 'power',
            'compile' => 'power'
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
        'abs' => [
            'custom' => false,
            'evaluate' => 'abs',
            'compile' => 'abs',
            'min_args' => 1,
            'max_args' => 1
        ],
        'acos' => [
            'custom' => false,
            'evaluate' => 'acos',
            'compile' => 'acos',
            'min_args' => 1,
            'max_args' => 1
        ],
        'acosh' => [
            'custom' => false,
            'evaluate' => 'acosh',
            'compile' => 'acosh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'asin' => [
            'custom' => false,
            'evaluate' => 'asin',
            'compile' => 'asin',
            'min_args' => 1,
            'max_args' => 1
        ],
        'asinh' => [
            'custom' => false,
            'evaluate' => 'asinh',
            'compile' => 'asinh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'atan' => [
            'custom' => false,
            'evaluate' => 'atan',
            'compile' => 'atan',
            'min_args' => 1,
            'max_args' => 1
        ],
        'atan2' => [
            'custom' => false,
            'evaluate' => 'atan2',
            'compile' => 'atan2',
            'min_args' => 2,
            'max_args' => 2
        ],
        'atanh' => [
            'custom' => false,
            'evaluate' => 'atanh',
            'compile' => 'atanh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'ceil' => [
            'custom' => false,
            'evaluate' => 'ceil',
            'compile' => 'ceil',
            'min_args' => 1,
            'max_args' => 1
        ],
        'cos' => [
            'custom' => false,
            'evaluate' => 'cos',
            'compile' => 'cos',
            'min_args' => 1,
            'max_args' => 1
        ],
        'cosh' => [
            'custom' => false,
            'evaluate' => 'cosh',
            'compile' => 'cosh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'exp' => [
            'custom' => false,
            'evaluate' => 'exp',
            'compile' => 'exp',
            'min_args' => 1,
            'max_args' => 1
        ],
        'floor' => [
            'custom' => false,
            'evaluate' => 'floor',
            'compile' => 'floor',
            'min_args' => 1,
            'max_args' => 1
        ],
        'log' => [
            'custom' => false,
            'evaluate' => 'log',
            'compile' => 'log',
            'min_args' => 1,
            'max_args' => 2
        ],
        'log10' => [
            'custom' => false,
            'evaluate' => 'log10',
            'compile' => 'log10',
            'min_args' => 1,
            'max_args' => 1
        ],
        'max' => [
            'custom' => false,
            'evaluate' => 'max',
            'compile' => 'max',
            'min_args' => 1,
            'max_args' => PHP_INT_MAX
        ],
        'min' => [
            'custom' => false,
            'evaluate' => 'min',
            'compile' => 'min',
            'min_args' => 1,
            'max_args' => PHP_INT_MAX
        ],
        'pi' => [
            'custom' => false,
            'evaluate' => 'pi',
            'compile' => 'pi',
            'min_args' => 0,
            'max_args' => 0
        ],
        'pow' => [
            'custom' => false,
            'evaluate' => 'pow',
            'compile' => 'pow',
            'min_args' => 2,
            'max_args' => 2
        ],
        'rand' => [
            'custom' => false,
            'evaluate' => 'rand',
            'compile' => 'rand',
            'min_args' => 0,
            'max_args' => 2
        ],
        'round' => [
            'custom' => false,
            'evaluate' => 'round',
            'compile' => 'round',
            'min_args' => 1,
            'max_args' => 2
        ],
        'sin' => [
            'custom' => false,
            'evaluate' => 'sin',
            'compile' => 'sin',
            'min_args' => 1,
            'max_args' => 1
        ],
        'sinh' => [
            'custom' => false,
            'evaluate' => 'sinh',
            'compile' => 'sinh',
            'min_args' => 1,
            'max_args' => 1
        ],
        'sqrt' => [
            'custom' => false,
            'evaluate' => 'sqrt',
            'compile' => 'sqrt',
            'min_args' => 1,
            'max_args' => 1
        ],
        'tan' => [
            'custom' => false,
            'evaluate' => 'tan',
            'compile' => 'tan',
            'min_args' => 1,
            'max_args' => 1
        ],
        'tanh' => [
            'custom' => false,
            'evaluate' => 'tanh',
            'compile' => 'tanh',
            'min_args' => 1,
            'max_args' => 1
        ]
    ];

    static $brackets = [['(', ')'], ['[', ']']];
    static $parameterSeparators = [',', ';'];
    static $quotemarks = ['"', '\''];
}