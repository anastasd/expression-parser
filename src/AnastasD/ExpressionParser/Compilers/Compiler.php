<?php

namespace AnastasD\ExpressionParser\Compilers;

use AnastasD\ExpressionParser\Settings as Settings;
use AnastasD\ExpressionParser\Mappers\Mapper as Mapper;
use AnastasD\ExpressionParser\Compilers\CompilerHelpers\CompilerHelper as CompilerHelper;

abstract class Compiler
{
    public Settings $settings;
    public Mapper $mapper;
    public CompilerHelper $compilerHelper;

    public array $variables;
    public array $operators;
    public array $functions;
    public array $brackets;
    public array $parameterSeparators;
    public array $quotemarks;
    public array $options;

    public function __construct(Mapper $mapper, CompilerHelper $helper)
    {
        $this->mapper = $mapper;

        $this->operators = $this->mapper::$operators;
        $this->functions = $this->mapper::$functions;
        $this->brackets = $this->mapper::$brackets;
        $this->parameterSeparators = $this->mapper::$parameterSeparators;
        $this->quotemarks = $this->mapper::$quotemarks;

        $this->compilerHelper = $helper;
    }

    public function prepareCompile(Settings $settings, $nodesList, array $variables, array $options = null): string
    {
        $this->settings = $settings;
        $this->variables = $variables;
        $this->options = $options ?? [];

        return $this->compile($nodesList);
    }

    public function compile(array $nodesList): string
    {
        $queue = [];

        foreach ($nodesList as $item) {
            switch ($item["type"]) {
                case "function":
                    $args = [];

                    if (array_key_exists("content", $item)) {
                        foreach ($item["content"] as $param) {
                            $args[] = "ref" === $param["type"] ? $this->settings->paramPrefix . $param["value"] : $param["value"];
                        }
                    }

                    $queue[] = [
                        $this->settings->paramPrefix . $item["id"],
                        $this->compilerHelper->{$this->functions[$item["name"]]["compile"]}($args)
                    ];

                    break;
                case "node":
                    $queueCter = 0;
                    $tmpContent = $item["content"];
                    $contentCter = count($tmpContent);

                    if (1 === $contentCter) {
                        $queue[] = [
                            $this->settings->paramPrefix . $item["id"],
                            "ref" === $item["content"][0]["type"] ? $this->settings->paramPrefix . $item["content"][0]["value"] : $item["content"][0]["value"]
                        ];
                    } else {
                        while (1 < $contentCter) {
                            $maxOrder = max(
                                array_map(function ($a) {
                                    return array_key_exists("order", $a) ? $a["order"] : -1;
                                }, $tmpContent)
                            );

                            for ($i = 0; $i < $contentCter; $i++) {
                                if ("operator" === $tmpContent[$i]["type"] && $maxOrder === $tmpContent[$i]["order"]) {
                                    $args = [
                                        "ref" === $tmpContent[$i - 1]["type"] ? $this->settings->paramPrefix . $tmpContent[$i - 1]["value"] : $tmpContent[$i - 1]["value"],
                                        "ref" === $tmpContent[$i + 1]["type"] ? $this->settings->paramPrefix . $tmpContent[$i + 1]["value"] : $tmpContent[$i + 1]["value"]
                                    ];

                                    $queue[] = [
                                        $this->settings->paramPrefix . $item["id"] . '_' . $queueCter,
                                        $this->compilerHelper->{$this->operators[$tmpContent[$i]["value"]]["compile"]}($args)
                                    ];

                                    $tmpContent[$i - 1] = [
                                        "type" => "temp",
                                        "value" => $this->settings->paramPrefix . $item["id"] . '_' . $queueCter
                                    ];

                                    array_splice($tmpContent, $i, 2);

                                    $queueCter++;

                                    $contentCter -= 2;
                                }
                            }
                        }

                        $queue[] = [
                            $this->settings->paramPrefix . $item["id"],
                            $tmpContent[0]["value"]
                        ];
                    }
                    break;
            }
        }

        $lastQueueItem = array_pop($queue);

        $search_array = [];
        $replace_array = [];
        if (false !== array_search("compress", $this->options)) {
            foreach ($queue as $item) {
                $replace_array[] = str_replace($search_array, $replace_array, $item[1]);
                $search_array[] = $item[0];
            }

            $result = array_pop($replace_array);

            $search_array = ["{{FUNCTION_PARAMS}}", "{{FUNCTION_BODY}}", "{{FUNCTION_RESULT}}"];
            $replace_array = [implode($this->parameterSeparators[0], $this->variables)];
            $replace_array[] = "";
            $replace_array[] = $result;

            $output = str_replace($search_array, $replace_array, $this->settings->compressedTemplate);
        } else {
            $search_array = ["{{FUNCTION_PARAMS}}", "{{FUNCTION_BODY}}", "{{FUNCTION_RESULT}}"];
            $replace_array[] = implode($this->parameterSeparators[0], $this->variables);

            $replace_array[] = array_reduce($queue, function ($carry, $item) {
                $carry .= $item[0] . '=' . $item[1] . ';';
                return $carry;
            });

            $replace_array[] = $lastQueueItem[1];

            $output = str_replace($search_array, $replace_array, $this->settings->longTemplate);
        }

        return $output;
    }
}