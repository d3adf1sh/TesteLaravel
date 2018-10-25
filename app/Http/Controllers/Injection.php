<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirstClass {
    public $firstValue = 10;
}

class SecondClass {
    public $secondValue = 20;
}

class Injection extends Controller {
    public function first(FirstClass $instance, $argument) {
        return $instance->firstValue.'.'.$argument;
    }

    public function second(SecondClass $instance, $argument) {
        return $instance->secondValue.'.'.$argument;
    }
}