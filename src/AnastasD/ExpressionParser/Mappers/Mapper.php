<?php

namespace AnastasD\ExpressionParser\Mappers;

/**
 * The abstract class of a mapper
 * @var array $operators an array of the operators
 */
abstract class Mapper
{
    /**
     * @example
     *   '+' => [
     *       'arity' => 'binary',
     *       'order' => 0,
     *       'evaluate' => 'add',
     *       'compile' => 'add'
     *   ],
     */
    public static $operators = [];
    public static $functions = [];

    public static $brackets = []; // [left,right]
    public static $argsSeparators = []; // Used to separate arguments in functions

    public static $quotemarks = [];
}