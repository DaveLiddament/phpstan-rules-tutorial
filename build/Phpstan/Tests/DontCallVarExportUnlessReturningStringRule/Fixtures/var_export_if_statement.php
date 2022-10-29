<?php

function output(bool $output): void
{
    var_export("A message", $output);

    if ($output === false) {
        return;
    }

    var_export("This is good", $output);
}
