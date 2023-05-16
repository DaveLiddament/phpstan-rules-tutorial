<?php

print("This is not allowed");

echo "This is not allowed";

function die_(): void
{
    die("This is not allowed");
}


goto end;
end:

exit("This is not allowed");