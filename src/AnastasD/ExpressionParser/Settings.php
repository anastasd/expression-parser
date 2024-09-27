<?php

namespace AnastasD\ExpressionParser;

class Settings
{
    const DEFAULT = 0;
    const PHP = 1;
    const JAVASCRIPT = 2;
    const SPREADSHEET = 3;
    const CUSTOM = 99;

    public string|null $functionRegex;
    public string|null $variableRegex;
    public string $paramPrefix;
    public string $longTemplate;
    public string $compressedTemplate;

    public Evaluators\Evaluator $evaluator;
    public Compilers\Compiler $compiler;

    public function __construct(int $mode = self::DEFAULT , array $options = null)
    {
        switch ($mode) {
            case self::DEFAULT:
                $this->evaluator = new Evaluators\EvaluatorDefault(
                    new Mappers\MapperDefault,
                    new Evaluators\EvaluatorHelpers\EvaluatorHelperDefault
                );
                $this->compiler = new Compilers\CompilerDefault(
                    new Mappers\MapperDefault,
                    new Compilers\CompilerHelpers\CompilerHelperDefault
                );

                $this->paramPrefix = '$param_';
                $this->longTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ {{FUNCTION_BODY}} return {{FUNCTION_RESULT}} ;}';
                $this->compressedTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ return {{FUNCTION_RESULT}} ;}';
                break;
            case self::PHP:
                $this->evaluator = new Evaluators\EvaluatorPHP(
                    new Mappers\MapperPHP,
                    new Evaluators\EvaluatorHelpers\EvaluatorHelperPHP
                );
                $this->compiler = new Compilers\CompilerPHP(
                    new Mappers\MapperPHP,
                    new Compilers\CompilerHelpers\CompilerHelperPHP
                );

                $this->paramPrefix = '$param_';
                $this->longTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ {{FUNCTION_BODY}} return {{FUNCTION_RESULT}} ;}';
                $this->compressedTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ return {{FUNCTION_RESULT}} ;}';
                break;
            case self::JAVASCRIPT:
                $this->evaluator = new Evaluators\EvaluatorJavaScript(
                    new Mappers\MapperJavascript,
                    new Evaluators\EvaluatorHelpers\EvaluatorHelperJavascript
                );
                $this->compiler = new Compilers\CompilerJavaScript(
                    new Mappers\MapperJavascript,
                    new Compilers\CompilerHelpers\CompilerHelperJavascript
                );

                $this->paramPrefix = '$param_';
                $this->longTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ {{FUNCTION_BODY}} return {{FUNCTION_RESULT}} ;}';
                $this->compressedTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ return {{FUNCTION_RESULT}} ;}';
                break;
            case self::SPREADSHEET:
                $this->functionRegex = '/^[a-zA-Z0-9_]+$/';
                $this->variableRegex = '/^\$?[A-Z]+\$?[0-9]+:?(\$?[A-Z]+)?(\$?[0-9]+)?$/';

                $this->evaluator = new Evaluators\EvaluatorSpreadsheet(
                    new Mappers\MapperSpreadsheet,
                    new Evaluators\EvaluatorHelpers\EvaluatorHelperSpreadsheet
                );
                $this->compiler = new Compilers\CompilerSpreadsheet(
                    new Mappers\MapperSpreadsheet,
                    new Compilers\CompilerHelpers\CompilerHelperSpreadsheet
                );

                $this->paramPrefix = '$param_';
                $this->longTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ {{FUNCTION_BODY}} return {{FUNCTION_RESULT}} ;}';
                $this->compressedTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ return {{FUNCTION_RESULT}} ;}';
                break;
            case self::CUSTOM:
                $this->functionRegex = array_key_exists("functionRegex", $options) ? $options["functionRegex"] : null;
                $this->variableRegex = array_key_exists("variableRegex", $options) ? $options["variableRegex"] : null;

                $this->evaluator = $options["evaluator"];
                $this->compiler = $options["compiler"];

                $this->paramPrefix = array_key_exists("paramPrefix", $options) ? $options["paramPrefix"] : '$param_';
                $this->longTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ {{FUNCTION_BODY}} return {{FUNCTION_RESULT}} ;}';
                $this->compressedTemplate = 'function expressionResult( {{FUNCTION_PARAMS}} ){ return {{FUNCTION_RESULT}} ;}';
                break;
            default:
                break;
        }
    }

    public function setFunctionRegex(string $regexStr)
    {
        $this->functionRegex = $regexStr;
    }

    public function setvariableRegex(string $regexStr)
    {
        $this->variableRegex = $regexStr;
    }

    public function setParamPrefix(string $prefix)
    {
        $this->paramPrefix = $prefix;
    }

    public function setLongTemplate(string $template)
    {
        $this->longTemplate = $template;
    }

    public function setCompressedTemplate(string $template)
    {
        $this->compressedTemplate = $template;
    }

    /**
     * @param string $symbol - the symbol of the operator
     */

    public function setOperator(
        string $symbol,
        string $arity,
        int $order,
        string $compilerCall,
        callable $compilerCallback,
        string $evaluatorCall,
        callable $evaluatorCallback
    ) {
        $this->compiler->mapper::$operators[$symbol] = [
            'arity' => $arity,
            'order' => $order,
            'compile' => $compilerCall
        ];
        $this->compiler->operators[$symbol] = [
            'arity' => $arity,
            'order' => $order,
            'compile' => $compilerCall
        ];
        $this->compiler->compilerHelper->setExpression($compilerCall, $compilerCallback);


        $this->evaluator->mapper::$operators[$symbol] = [
            'arity' => $arity,
            'order' => $order,
            'evaluate' => $evaluatorCall
        ];
        $this->evaluator->operators[$symbol] = [
            'arity' => $arity,
            'order' => $order,
            'evaluate' => $evaluatorCall
        ];
        $this->evaluator->evaluatorHelper->setExpression($evaluatorCall, $evaluatorCallback);
    }

    public function removeOperator(string $symbol, bool $removeExpression = false)
    {
        $operator = $this->compiler->mapper::$operators[$symbol];

        unset($this->compiler->mapper::$operators[$symbol]);
        unset($this->compiler->operators[$symbol]);

        unset($this->evaluator->mapper::$operators[$symbol]);
        unset($this->evaluator->operators[$symbol]);

        if ($removeExpression) {
            $this->compiler->compilerHelper->removeExpression($operator["compile"]);
            $this->evaluator->evaluatorHelper->removeExpression($operator["evaluate"]);
        }
    }

    public function setFunction(
        string $name,
        int $minArgs,
        int $maxArgs,
        string $compilerCall,
        callable $compilerCallback,
        string $evaluatorCall,
        callable $evaluatorCallback
    ) {
        $this->compiler->mapper::$functions[$name] = [
            'min_args' => $minArgs,
            'max_args' => $maxArgs,
            'compile' => $compilerCall
        ];
        $this->compiler->functions[$name] = [
            'min_args' => $minArgs,
            'max_args' => $maxArgs,
            'compile' => $compilerCall
        ];
        $this->compiler->compilerHelper->setExpression($compilerCall, $compilerCallback);


        $this->evaluator->mapper::$functions[$name] = [
            'min_args' => $minArgs,
            'max_args' => $maxArgs,
            'evaluate' => $evaluatorCall
        ];
        $this->evaluator->functions[$name] = [
            'min_args' => $minArgs,
            'max_args' => $maxArgs,
            'evaluate' => $evaluatorCall
        ];
        $this->evaluator->evaluatorHelper->setExpression($evaluatorCall, $evaluatorCallback);
    }

    public function removeFunction(string $name, bool $removeExpression = false)
    {
        $function = $this->compiler->mapper::$functions[$name];

        unset($this->compiler->mapper::$functions[$name]);
        unset($this->compiler->functions[$name]);

        unset($this->evaluator->mapper::$functions[$name]);
        unset($this->evaluator->functions[$name]);

        if ($removeExpression) {
            $this->compiler->compilerHelper->removeExpression($function["compile"]);
            $this->evaluator->evaluatorHelper->removeExpression($function["evaluate"]);
        }
    }
}