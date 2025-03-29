<?php
function clean_input($input)
{
    $input = trim($input);

    $input = stripslashes($input);

    $input = htmlspecialchars($input);

    $input = strip_tags($input);

    return $input;
}
