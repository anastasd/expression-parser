<?php

namespace AnastasD\ExpressionParser\Evaluators;

use AnastasD\ExpressionParser\Settings as Settings;
use AnastasD\ExpressionParser\Mappers\Mapper as Mapper;
use AnastasD\ExpressionParser\Evaluators\EvaluatorHelpers\EvaluatorHelper as EvaluatorHelper;

abstract class Evaluator
{
    public Settings $settings;
    public Mapper $mapper;
    public EvaluatorHelper $evaluatorHelper;

    public array $variables;
    public array $operators;
    public array $functions;
    public array $brackets;
    public array $argsSeparators;
    public array $quotemarks;
    public array $options = [];
    public array $values = [];

    public function __construct(Mapper $mapper, EvaluatorHelper $helper)
    {
        $this->mapper = $mapper;

        $this->operators = $this->mapper::$operators;
        $this->functions = $this->mapper::$functions;
        $this->brackets = $this->mapper::$brackets;
        $this->argsSeparators = $this->mapper::$argsSeparators;
        $this->quotemarks = $this->mapper::$quotemarks;

        $this->evaluatorHelper = $helper;
    }

    public function prepareEvaluate(Settings $settings, $nodesList, array $variables, array $values, array $options = null): string
    {
        $this->settings = $settings;
        $this->variables = $variables;
        $this->options = $options ?? [];
        $this->values = $values ?? [];

        return $this->evaluate($nodesList, $this->values, $this->options);
    }

    public function evaluate(array $nodesList, array $values, array $options): string
    {
        $temps = [];

        foreach ($this->variables as $key => $variable) {
            $temps[$values[$key]] = $variable;
        }

        foreach ($nodesList as $item) {
            switch ($item["type"]) {
                case "function":
                    $args = [];

                    if (array_key_exists("content", $item)) {
                        foreach ($item["content"] as $param) {
                            switch ($param["type"]) {
                                case "ref":
                                case "variable":
                                    $args[] = $temps[$this->settings->paramPrefix . $param["value"]];
                                    break;
                                default:
                                    $args[] = $param["value"];
                                    break;
                            }
                        }
                    }

                    $temps[$this->settings->paramPrefix . $item["id"]] = $this->evaluatorHelper->{$this->functions[$item["name"]]["evaluate"]}($args);
                    break;
                case "node":
                    $queueCter = 0;
                    $tmpContent = $item["content"];
                    $contentCter = count($tmpContent);

                    if (1 === $contentCter) {
                        switch ($item["content"][0]["type"]) {
                            case "ref":
                                $temps[$this->settings->paramPrefix . $item["id"]] = $temps[$this->settings->paramPrefix . $item["content"][0]["value"]];
                                break;
                            case "variable":
                                $temps[$this->settings->paramPrefix . $item["id"]] = $temps[$item["content"][0]["value"]];
                                break;
                            default:
                                $temps[$this->settings->paramPrefix . $item["id"]] = $item["content"][0]["value"];
                                break;
                        }
                    } else {
                        while (1 < $contentCter) {
                            $maxOrder = max(
                                array_map(function ($a) {
                                    return array_key_exists("order", $a) ? $a["order"] : -1;
                                }, $tmpContent)
                            );

                            for ($i = 0; $i < $contentCter; $i++) {
                                if ("operator" === $tmpContent[$i]["type"] && $maxOrder === $tmpContent[$i]["order"]) {
                                    $args = [];

                                    switch ($tmpContent[$i - 1]["type"]) {
                                        case "ref":
                                            $args[] = $temps[$this->settings->paramPrefix . $tmpContent[$i - 1]["value"]];
                                            break;
                                        case "variable":
                                            $args[] = $temps[$tmpContent[$i - 1]["value"]];
                                            break;
                                        default:
                                            $args[] = $tmpContent[$i - 1]["value"];
                                            break;
                                    }

                                    switch ($tmpContent[$i + 1]["type"]) {
                                        case "ref":
                                            $args[] = $temps[$this->settings->paramPrefix . $tmpContent[$i + 1]["value"]];
                                            break;
                                        case "variable":
                                            $args[] = $temps[$tmpContent[$i + 1]["value"]];
                                            break;
                                        default:
                                            $args[] = $tmpContent[$i + 1]["value"];
                                            break;
                                    }

                                    $temps[$this->settings->paramPrefix . $item["id"] . '_' . $queueCter] = $this->evaluatorHelper->{$this->operators[$tmpContent[$i]["value"]]["evaluate"]}($args);

                                    $tmpContent[$i - 1] = [
                                        "type" => "temp",
                                        "value" => $temps[$this->settings->paramPrefix . $item["id"] . '_' . $queueCter]
                                    ];

                                    array_splice($tmpContent, $i, 2);

                                    $queueCter++;

                                    $contentCter -= 2;

                                }
                            }
                        }

                        $temps[$this->settings->paramPrefix . $item["id"]] = $tmpContent[0]["value"];
                    }
                    break;
            }
        }

        $lastItem = array_pop($temps);

        return $lastItem;
    }
}