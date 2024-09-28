# Expression Parser
A PHP library for parsing arithmetic expressions and functions in different programming languages


## How can the Expression Parser help?
- If you have to run code that uses unsafe input the parser will make sure that no damage is made to the server and other code;
- If the function *eval()* is not available on your server the evaluator can replace it;
- If you want to limit the functions of the input to a given list a custom-built parser can do that for you;
- If you want to "translate" expressions written in other programming languages and even spreadsheet functions to PHP the parser can do that;

## Use cases
- An online spreadsheet application that uses backend evaluation of cell content;
- Any application that requires custom mathematical logic;
- and many more ...


## Features


## Limitations
Unary operators are not available (yet), just binary.