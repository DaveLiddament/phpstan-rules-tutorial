<?php

function foo(): void {}

foo(); // OK

var_export("Not allowed"); // ERROR
var_export("Still not allowed", false); // ERROR
var_export("All OK", true); // OK
