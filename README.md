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


## Limitations
Unary operators are not available (yet), just binary.