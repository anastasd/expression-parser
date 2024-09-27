<?php

namespace AnastasD\ExpressionParser\Mappers;

abstract class Mapper
{
    public static $operators = [];
    public static $functions = [];

    public static $brackets = []; // [left,right]
    public static $parameterSeparators = []; // Used to separate parameters in functions

    public static $quotemarks = [];
}