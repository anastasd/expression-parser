<?php

namespace AnastasD\ExpressionParser\Exceptions;

class ParsingException extends \Exception
{
    private $_input;
    private $_nodes;

    public function __construct($message, $input = null, $nodes = null)
    {
        $this->_input = $input;
        $this->_nodes = $nodes;

        parent::__construct($message);
    }

    public function __toString(): string
    {
        $message = $this->getMessage() . ";\n";

        if (!is_null($this->_input)) {
            $message .= "Input string: \"$this->_input\";\n";
        }
        if (!is_null($this->_nodes)) {
            $message .= "Nodes: " . json_encode($this->_nodes) . ";\n";
        }

        return $message;
    }
}