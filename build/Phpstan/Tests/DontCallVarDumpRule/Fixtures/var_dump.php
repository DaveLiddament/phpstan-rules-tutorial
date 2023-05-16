<?php

var_dump("A message");

function isAdult(int $age): bool
{
    return $age >= 18;
}

isAdult(17);