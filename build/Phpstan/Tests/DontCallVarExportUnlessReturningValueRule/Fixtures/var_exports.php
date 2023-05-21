<?php

var_export("Message"); // ERROR
var_export("Message", false); // ERROR
var_export("Message", true); // OK


function takesBool(bool $bool): void
{
    var_export("Message", $bool); // ERROR

    if ($bool === false) {
        return;
    }

    var_export("Message", $bool); // OK
}