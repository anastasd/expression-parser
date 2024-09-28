<?php

namespace AnastasD\ExpressionParser;

class Parser
{
    public Settings $settings;

    public array $variables;
    public string|null $variableRegex;
    public string|null $functionRegex;

    public string $input = '';
    public array $paramSeparators = [];

    private array $_inverseOperators = [];
    private array $_inverseFunctions = [];
    private array $_inverseargsSeparators = [];
    private array $_inverseQuotemarks = [];
    private array $_inverseVaribles = [];
    private array $_bracketPairs = [];
    private array $_bracketLevels = [];

    private array $_nodesList = [];
    private int $_cNode = 0;
    private int $_nodeCter = 0;

    private array $_direct = [];
    private array $_inverse = [];

    public array $queue = [];

    /**
     * Initialisation of the parser.
     * @param \AnastasD\ExpressionParser\Settings $settings - settings of the parser
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;

        $this->_initializeInverseLookup();
        $this->_initializeBracketLookup();

        $this->variableRegex = $this->settings->variableRegex ?? null;
        $this->functionRegex = $this->settings->functionRegex ?? null;
    }

    private function _initializeInverseLookup(): void
    {
        $this->_inverseOperators = array_fill_keys(array_keys($this->settings->compiler->operators), 'operator');
        $this->_inverseFunctions = array_fill_keys(array_keys($this->settings->compiler->functions), 'function');
        $this->_inverseargsSeparators = array_fill_keys($this->settings->compiler->argsSeparators, 'parameter_separator');
        $this->_inverseQuotemarks = array_fill_keys($this->settings->compiler->quotemarks, 'quotemark');

        $this->_direct = array_merge(
            array_keys($this->settings->compiler->operators),
            array_keys($this->settings->compiler->functions),
            $this->settings->compiler->argsSeparators,
            $this->settings->compiler->quotemarks
        );
        $this->_inverse = array_merge($this->_inverseOperators, $this->_inverseFunctions, $this->_inverseargsSeparators, $this->_inverseQuotemarks);
    }

    private function _initializeBracketLookup(): void
    {
        foreach ($this->settings->compiler->brackets as $item) {
            $this->_inverse[$item[0]] = 'left_bracket';
            $this->_inverse[$item[1]] = 'right_bracket';
            $this->_bracketPairs[$item[1]] = $item[0];
            $this->_bracketLevels[$item[0]] = 0;
        }
    }

    /**
     * Parses the input 
     * @param string $input - the string that shall be parsed
     * @param array $variables - a list of variables that shall be searched in the input
     * @return static
     */
    public function parse(string $input, array $variables = [])
    {
        /* First - reset the counters */
        $this->_nodeCter = 0;
        $this->_cNode = 0;
        $this->_nodesList = [[
            'type' => 'node',
            'id' => 0,
            'min_ref' => PHP_INT_MAX,
            'parent' => null,
            'content' => []
        ]];

        $this->variables = $variables;
        $this->_inverseVaribles = array_fill_keys($this->variables, 'variable');

        $this->_direct = array_merge($this->_direct, $this->variables);
        $this->_inverse = array_merge($this->_inverse, $this->_inverseVaribles);

        $this->input = trim(preg_replace(['/[^\S]/'], [''], $input));

        // "Completing" floats with a zero 
        $this->input = preg_replace_callback('/(^|\D)\.(\d+)/', function ($matches) {
            switch ($matches[1]) {
                case "":
                    return "0.$matches[2]";
                case " ":
                    return " 0.$matches[2]";
                default:
                    return "$matches[1]0.$matches[2]";
            }
        }, $this->input);


        Validators\Validator::checkBalancedBrackets($input, $this->_bracketPairs);

        $this->_scan($this->input);

        Validators\Validator::checkFunctionArgsCount($this->_nodesList, $this->settings->compiler->mapper);

        // echo json_encode($this->_nodesList) . "\n\n";

        return $this;
    }

    /**
     * Runs the validators and sorts the nodeList in order of execution
     * @throws \AnastasD\ExpressionParser\Exceptions\ParsingException
     * @return \AnastasD\ExpressionParser\Parser
     */
    public function prepare(): self
    {
        /* Fix if the first content item is minus or plus */
        /* Fix if the length of content is an even number */
        foreach ($this->_nodesList as &$node) {
            if (
                "-" === $node["content"][0]["value"]
                || "+" === $node["content"][0]["value"]
            ) {
                array_unshift($node["content"], ["type" => "number", "value" => 0]);
            }

            if (
                "node" === $node["type"]
                && 0 === count($node["content"]) % 2
            ) {
                throw new Exceptions\ParsingException("Unbalanced operators", null, $node);
            }
        }


        usort($this->_nodesList, function ($a, $b) {
            return $a['min_ref'] < $b['min_ref'] ? 1 : -1;
        });

        // echo json_encode($this->_nodesList) . "\n\n";

        return $this;
    }

    /**
     * Evaluates the input with values for the variables
     * @param array $values the values that shall be used in the evaluation
     * @param array $options not used for now
     * @return string
     */
    public function evaluate(array $values = null, array $options = null)
    {
        return $this->settings->evaluator->prepareEvaluate($this->settings, $this->_nodesList, $values, $this->variables, $options);
    }

    /**
     * Compiles the nodes after successfull parsing
     * @param array $options if "compress" is provided then the returned code is shorter
     * @return string
     */
    public function compile(array $options = null)
    {
        return $this->settings->compiler->prepareCompile($this->settings, $this->_nodesList, $this->variables, $options);
    }

    /**
     * Returns the list of nodes after successfull parsing
     * @return array
     */
    public function getNodeList() {
        return $this->_nodesList;
    }

    private function _scan(string $input)
    {
        $chars = str_split($input);
        $charsLength = count($chars);
        $charCter = 0;
        $buffer = '';
        $bufferType = '';


        while ($charCter < $charsLength) {
            $bufferPlusOne = $buffer . $chars[$charCter];

            if (
                ' ' === $chars[$charCter]
            ) {
                $bufferType = $this->_inverse[$buffer];

                switch ($bufferType) {
                    case 'operator':
                        $this->_parseOperator($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    case 'left_bracket':
                        $this->_parseLeftBracket($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    case 'function':
                        $this->_parseFunction($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    case 'quotemark':
                        $this->_parseQuotemark($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    case 'variable':
                        $this->_parseVariable($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                }

                $buffer = '';
                $charCter++;
            } elseif (
                "" !== $buffer // Otherwise the loop might be infinite
                && array_key_exists($buffer, $this->_inverse)  // If there is a match
                && (0 === count( // ... but there are no other candidates.
                    array_filter(
                        $this->_direct,
                        function ($item) use ($bufferPlusOne) {
                            return 0 === strpos($item, $bufferPlusOne);
                        }
                    )
                ) || "" === $chars[$charCter])
            ) {
                $bufferType = $this->_inverse[$buffer];

                switch ($bufferType) {
                    case 'operator':
                        $this->_parseOperator($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    case 'left_bracket':
                        $this->_parseLeftBracket($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    case 'function':
                        $this->_parseFunction($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    case 'quotemark':
                        $this->_parseQuotemark($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    case 'variable':
                        $this->_parseVariable($chars, $charCter, $buffer, $bufferType, $charsLength);
                        break;
                    default:
                        $charCter++;
                        break;
                }
            } elseif (
                null !== $this->functionRegex
                && "" !== $buffer
                && array_key_exists(
                    $chars[$charCter],
                    $this->_bracketLevels
                ) && preg_match($this->functionRegex, $buffer)
            ) {
                $this->_parseFunction($chars, $charCter, $buffer, $bufferType, $charsLength);
            } elseif (
                null !== $this->variableRegex
                && preg_match($this->variableRegex, $buffer)
                && !preg_match($this->variableRegex, $bufferPlusOne)  // Better solution??
            ) {
                $this->_parseVariable($chars, $charCter, $buffer, $bufferType, $charsLength);
            } elseif (
                is_numeric($buffer)
                && (!is_numeric($bufferPlusOne) || $charCter === $charsLength)
            ) {
                $this->_parseNumber($chars, $charCter, $buffer, $bufferType, $charsLength);
            } else {
                $buffer .= $chars[$charCter];
                $charCter++;
            }
        }


        // If any leftovers ...
        if ('' != $buffer) {
            if (array_key_exists($buffer, $this->_inverse)) {
                $bufferType = $this->_inverse[$buffer];

                if ('operator' === $bufferType) {
                    $this->_nodesList[$this->_cNode]['content'][] = [
                        'type' => 'operator',
                        'order' => $this->settings->compiler->operators[$buffer]['order'],
                        'value' => $buffer
                    ];
                } else {
                    $this->_nodesList[$this->_cNode]['content'][] = [
                        'type' => $bufferType,
                        'value' => $buffer
                    ];
                }
            } elseif (
                null !== $this->variableRegex
                && preg_match($this->variableRegex, $buffer)
            ) {
                $this->_parseVariable($chars, $charCter, $buffer, $bufferType, $charsLength);
            } elseif (is_numeric($buffer)) {
                $this->_parseNumber($chars, $charCter, $buffer, $bufferType, $charsLength);
            } else {
                throw new Exceptions\ParsingException('Unknown symbol "' . $buffer . '"', $input, $this->_nodesList);
            }
        }
    }

    private function _parseOperator(&$chars, &$charCter, &$buffer, &$bufferType, $charsLength): void
    {
        $this->_nodesList[$this->_cNode]['content'][] = [
            'type' => 'operator',
            'order' => $this->settings->compiler->operators[$buffer]['order'],
            'value' => $buffer
        ];
        $buffer = $chars[$charCter];
        $bufferType = '';
        $charCter++;
    }

    private function _parseLeftBracket(&$chars, &$charCter, &$buffer, &$bufferType, $charsLength): void
    {
        $this->_bracketLevels[$buffer]++;
        $plain = '';

        $node = [
            'type' => 'node',
            'min_ref' => PHP_INT_MAX,
            'parent' => $this->_cNode,
            'plain' => ''
        ];

        $this->_nodeCter++;

        $this->_nodesList[$this->_cNode]['content'][] = [
            'type' => 'ref',
            'value' => $this->_nodeCter
        ];
        $this->_nodesList[$this->_cNode]['min_ref'] = min($this->_nodesList[$this->_cNode]['min_ref'], $this->_nodeCter);

        do {
            switch (true) {
                case array_key_exists($chars[$charCter], $this->_inverse) && 'left_bracket' === $this->_inverse[$chars[$charCter]]:
                    $this->_bracketLevels[$chars[$charCter]]++;
                    $plain .= $chars[$charCter];
                    break;
                case array_key_exists($chars[$charCter], $this->_inverse) && 'right_bracket' === $this->_inverse[$chars[$charCter]]:
                    $this->_bracketLevels[$this->_bracketPairs[$chars[$charCter]]]--;
                    break;
                default:
                    $plain .= $chars[$charCter];
                    break;
            }

            $charCter++;
        } while (!empty(array_filter($this->_bracketLevels)) && $charCter < $charsLength); // A hack to quickly check if all items in $this->_bracketLevels are equal to zero

        $node['plain'] = $plain;

        $node['id'] = $this->_nodeCter;
        $this->_nodesList[$this->_nodeCter] = $node;
        $this->_cNode = $node['parent'];

        $buffer = '';
        $bufferType = '';
    }

    private function _parseFunction(&$chars, &$charCter, &$buffer, &$bufferType, $charsLength): void
    {
        $this->_bracketLevels[$chars[$charCter]]++;
        $openingBracket = $chars[$charCter];
        $charCter++;
        $plain = '';

        $node = [
            'type' => 'function',
            'name' => $buffer,
            'min_ref' => PHP_INT_MAX,
            'parent' => $this->_cNode,
            'params' => []
        ];

        $this->_nodeCter++;

        $this->_nodesList[$this->_cNode]['content'][] = [
            'type' => 'ref',
            'value' => $this->_nodeCter
        ];
        $this->_nodesList[$this->_cNode]['min_ref'] = min($this->_nodesList[$this->_cNode]['min_ref'], $this->_nodeCter);

        do {
            switch (true) {
                case array_key_exists($chars[$charCter], $this->_inverse) && 'left_bracket' === $this->_inverse[$chars[$charCter]]:
                    $this->_bracketLevels[$chars[$charCter]]++;
                    $plain .= $chars[$charCter];
                    break;
                case array_key_exists($chars[$charCter], $this->_inverse) && 'right_bracket' === $this->_inverse[$chars[$charCter]]:
                    $this->_bracketLevels[$this->_bracketPairs[$chars[$charCter]]]--;
                    $plain .= $chars[$charCter];
                    break;
                case (
                array_key_exists($chars[$charCter], $this->_inverse)
                && 'parameter_separator' === $this->_inverse[$chars[$charCter]]
                && 1 === $this->_bracketLevels[$openingBracket]
                ):
                    if ('' !== $plain) {
                        $node['params'][] = $plain;
                    }
                    $plain = '';
                    break;
                default:
                    $plain .= $chars[$charCter];
                    break;
            }

            $charCter++;
        } while (!empty(array_filter($this->_bracketLevels)) && $charCter < $charsLength); // A hack to quickly check if all items in $this->_bracketLevels are equal to zero

        $trimmed = substr($plain, 0, -1);
        if ('' !== $trimmed) {
            $node['params'][] = $trimmed;
        }

        $node['id'] = $this->_nodeCter;
        $this->_nodesList[$this->_nodeCter] = $node;

        $buffer = '';
        $bufferType = '';

        $this->_cNode = $this->_nodeCter;
        foreach ($node["params"] as $param) { // Child node is created for each parameter
            $this->_nodeCter++;
            $this->_nodesList[$this->_nodeCter] = [
                'id' => $this->_nodeCter,
                'type' => 'node',
                'content' => [],
                'parent' => $this->_cNode,
                'min_ref' => PHP_INT_MAX
            ];

            $this->_nodesList[$this->_cNode]['content'][] = [
                'type' => 'ref',
                'value' => $this->_nodeCter
            ];
            $this->_nodesList[$this->_cNode]['min_ref'] = min($this->_nodesList[$this->_cNode]['min_ref'], $this->_nodeCter);

            $this->_cNode = $this->_nodeCter;

            $this->_scan($param);

            $this->_cNode = $this->_nodesList[$this->_cNode]['parent'];
        }

        $this->_cNode = $node['parent'];
    }

    private function _parseQuotemark(&$chars, &$charCter, &$buffer, &$bufferType, $charsLength): void
    {
        $plain = '';

        do {
            $plain .= $chars[$charCter];
            $charCter++;
        } while ($chars[$charCter] !== $buffer);

        $this->_nodesList[$this->_cNode]['content'][] = [
            'type' => 'string',
            'value' => $buffer . $plain . $buffer
        ];

        $buffer = '';
        $bufferType = '';
        $charCter++;
    }

    private function _parseVariable(&$chars, &$charCter, &$buffer, &$bufferType, $charsLength): void
    {
        $this->_nodesList[$this->_cNode]['content'][] = [
            'type' => 'variable',
            'value' => $buffer
        ];

        $buffer = '';
        $bufferType = '';
    }

    private function _parseNumber(&$chars, &$charCter, &$buffer, &$bufferType, $charsLength): void
    {
        $this->_nodesList[$this->_cNode]['content'][] = [
            'type' => 'number',
            'value' => (float) $buffer
        ];

        $buffer = '';
        $bufferType = '';
    }
}