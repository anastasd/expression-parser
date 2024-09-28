<?php

class CustomMapper extends AnastasD\ExpressionParser\Mappers\Mapper
{
    static $operators = [
        '\\' => [
            'arity' => 'binary',
            'custom' => false,
            'order' => 0,
            'evaluate' => 'eucl',
            'compile' => 'eucl'
        ]
    ];

    static $functions = [
        'xor' => [
            'evaluate' => 'xor',
            'compile' => 'xor',
            'min_args' => 2,
            'max_args' => 2
        ]
    ];

    static $brackets = [['(', ')']];
    static $parameterSeparators = [',', ';'];
    static $quotemarks = ['"', '\''];
}