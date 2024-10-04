# Expression Parser
A PHP library for parsing arithmetic expressions and functions in different programming languages


## How can the Expression Parser help?
- If you need to run code that uses unsafe input, the parser ensures no harm is done to the server or other code.
- If the eval() function is unavailable on your server, the evaluator can replace it.
- If you want to restrict the input functions to a specific list, a custom-built parser can handle that for you.
- If you want to “translate” expressions written in other programming languages or even spreadsheet functions to PHP, the parser can do that.


## Use cases
- An online spreadsheet application that uses backend evaluation of cell content;
- Any application that requires custom mathematical logic;
- and many more ...


## Features
- 

## Limitations
Unary operators are not available (yet), just binary.

## Examples
```php
<?php
$settings = new Settings(Settings::PHP);
$parser = new Parser($settings);

$input = '-pow($a, 2) * sin(log($b)) + cos(sqrt($c)) * exp(tan($d)) / log(abs($e)) - sqrt(pow($f, 3))';

echo $parser->parse($input, ['$a', '$b', '$c', '$d', '$e', '$f'])
     ->prepare()
     ->compile();
```

The output is `function expressionResult( $a,$b,$c,$d,$e,$f ){ $param_24=3;$param_2=$a;$param_3=2;$param_23=$f;$param_7=$b;$param_19=$e;$param_11=$c;$param_15=$d;$param_22=pow($param_23, $param_24);$param_21=$param_22;$param_20=sqrt($param_21);$param_18=abs($param_19);$param_17=$param_18;$param_16=log($param_17, M_E);$param_14=tan($param_15);$param_13=$param_14;$param_12=exp($param_13);$param_10=sqrt($param_11);$param_9=$param_10;$param_8=cos($param_9);$param_6=log($param_7, M_E);$param_5=$param_6;$param_4=sin($param_5);$param_1=pow($param_2, $param_3);$param_0_0=$param_1*$param_4;$param_0_1=$param_8*$param_12;$param_0_2=$param_0_1/$param_16;$param_0_3=0-$param_0_0;$param_0_4=$param_0_2-$param_20;$param_0_5=$param_0_3+$param_0_4; return $param_0_5 ;}`

```php
<?php
$settings = new Settings(Settings::PHP);
$parser = new Parser($settings);

$input = '-pow($a, 2) * sin(log($b)) + cos(sqrt($c)) * exp(tan($d)) / log(abs($e)) - sqrt(pow($f, 3))';

echo $parser->parse($input, ['$a', '$b', '$c', '$d', '$e', '$f'])
     ->prepare()
     ->evaluate([1, 2, 3, 4, 5, 6]);
```

The output is `-15.653432949851`