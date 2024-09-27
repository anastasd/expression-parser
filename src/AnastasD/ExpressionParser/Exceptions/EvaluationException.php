<?php

namespace AnastasD\ExpressionParser\Exceptions;

class EvaluationException extends \Exception
{
    private $_input;
    private $_node;

    public function __construct($message, $input = null, $node = null)
    {
        $this->_input = $input;
        $this->_node = $node;

        parent::__construct($message);
    }

    public function __toString(): string
    {
        $message = $this->getMessage() . ";\n";

        if (!is_null($this->_input)) {
            $message .= "Input string: \"$this->_input\";\n";
        }
        if (!is_null($this->_node)) {
            $message .= "Node: " . json_encode($this->_node) . ";\n";
        }

        return $message;
    }
}