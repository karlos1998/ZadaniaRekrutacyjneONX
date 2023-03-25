<?php

class TextInput {
    protected $value = '';
  
    public function add($text) {
      $this->value .= $text;
    }
  
    public function getValue() {
      return $this->value;
    }
  }
  
  class NumericInput extends TextInput {
    public function add($text) {
      if (preg_match('/^[0-9]+$/', $text)) {
        $this->value .= $text;
      }
    }
  }



$test1 = new TextInput();
$test1->add('1');
$test1->add('q');
$test1->add('3');
$test1->add('44');

echo $test1->getValue(); //1q344

echo PHP_EOL;

$test2 = new NumericInput();
$test2->add('1');
$test2->add('q');
$test2->add('3');
$test2->add('44');

echo $test2->getValue(); //1344