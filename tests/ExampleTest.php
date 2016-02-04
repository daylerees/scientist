<?php

use Scientist\Laboratory;

class ExampleTest extends PHPUnit_Framework_TestCase
{
    public function test_to_run_a_simple_experiment_with_no_journals()
    {
        $string = 'My name is _NAME_.';

        $stringReplacement = function () use ($string) {
            return str_replace('_NAME_', 'Dayle', $string);
        };

        $regexReplacement = function () use ($string) {
            return preg_replace('/\_NAME\_/', 'Dayle', $string);
        };

        $value = (new Laboratory)
            ->experiment('Replace name in a string.')
            ->control($stringReplacement)
            ->trial('Use preg_replace().', $regexReplacement)
            ->run();

        $this->assertEquals('My name is Dayle.', $value);
    }

    public function test_to_run_a_simple_experiment_with_no_journals_and_check_result()
    {
        $string = 'My name is _NAME_.';

        $stringReplacement = function () use ($string) {
            return str_replace('_NAME_', 'Dayle', $string);
        };

        $regexReplacement = function () use ($string) {
            return preg_replace('/\_NAME\_/', 'Dayle', $string);
        };

        $result = (new Laboratory)
            ->experiment('Replace name in a string.')
            ->control($stringReplacement)
            ->trial('Use preg_replace().', $regexReplacement)
            ->result();

        $this->assertInternalType('float', $result->control()->getTime());
        $this->assertEquals('My name is Dayle.', $result->control()->getValue());

        $trial = current($result->trials());
        $this->assertInternalType('float', $trial->getTime());
        $this->assertEquals('My name is Dayle.', $trial->getValue());
        $this->assertTrue($trial->isMatch());
    }
}
