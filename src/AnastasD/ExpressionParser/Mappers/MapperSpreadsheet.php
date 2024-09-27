<?php

namespace AnastasD\ExpressionParser\Mappers;

class MapperSpreadsheet extends Mapper
{
    static $operators = [
        '+' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 0,
            'call' => 'add',
            'compile' => 'add'
        ],
        '-' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 0,
            'call' => 'subtract',
            'compile' => 'subtract'
        ],
        '*' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 1,
            'call' => 'multiply',
            'compile' => 'multiply'
        ],
        '^' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 2,
            'call' => 'power',
            'compile' => 'power'
        ],
        '/' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 1,
            'call' => 'divide',
            'compile' => 'divide'
        ],
        '=' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 0,
            'call' => 'equals',
            'compile' => 'equals'
        ]
    ];

    static $functions = [];
    static $brackets = [['(', ')'], ['[', ']']];
    static $parameterSeparators = [',', ';'];
    static $quotemarks = ['"', '\''];
}