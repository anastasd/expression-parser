<?php

use PHPUnit\Framework\TestCase;

use AnastasD\ExpressionParser\Settings;
use AnastasD\ExpressionParser\Parser;


class TestRegex extends TestCase
{
    public function testVariableRegex()
    {
        $settings = new Settings(Settings::PHP);

        $settings->setVariableRegex('/^\$\w+$/');

        $parser = new Parser($settings);

        $input = '$a+ $b ';

        $output = $parser->parse($input)
            ->prepare()
            ->compile([]);

        $this->assertEquals('function expressionResult( $a,$b ){ $param_0_0=($a+$b); return $param_0_0 ;}', $output);
    }

    public function testFunctionRegex()
    {
        $settings = new Settings(Settings::PHP);

        $settings->setFunctionRegex('/^\w+$/');

        $parser = new Parser($settings);

        $input = '- blah(mlah(3,$a- hrah(6 /$b)), 4)';

        $parser->parse($input, ['$a', '$b']);

        $output = json_encode($parser->getNodeList());

        $this->assertEquals('[{"type":"node","id":0,"min_ref":1,"parent":null,"content":[{"type":"operator","order":0,"value":"-"},{"type":"ref","value":1}]},{"type":"function","name":"blah","min_ref":2,"parent":0,"params":["mlah(3,$a-hrah(6\/$b))","4"],"id":1,"content":[{"type":"ref","value":2},{"type":"ref","value":8}]},{"id":2,"type":"node","content":[{"type":"ref","value":3}],"parent":1,"min_ref":3},{"type":"function","name":"mlah","min_ref":4,"parent":2,"params":["3","$a-hrah(6\/$b)"],"id":3,"content":[{"type":"ref","value":4},{"type":"ref","value":5}]},{"id":4,"type":"node","content":[{"type":"number","value":3}],"parent":3,"min_ref":9223372036854775807},{"id":5,"type":"node","content":[{"type":"variable","value":"$a"},{"type":"operator","order":0,"value":"-"},{"type":"ref","value":6}],"parent":3,"min_ref":6},{"type":"function","name":"hrah","min_ref":7,"parent":5,"params":["6\/$b"],"id":6,"content":[{"type":"ref","value":7}]},{"id":7,"type":"node","content":[{"type":"number","value":6},{"type":"operator","order":1,"value":"\/"},{"type":"variable","value":"$b"}],"parent":6,"min_ref":9223372036854775807},{"id":8,"type":"node","content":[{"type":"number","value":4}],"parent":1,"min_ref":9223372036854775807}]', $output);
    }
}