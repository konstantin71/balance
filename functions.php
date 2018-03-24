<?php

function debug($arr)
{
    echo "<br />"."<br />"."<br />" ;
    echo '<pre>' . print_r($arr, true) . '</pre>';
}


function md($arg)
{
    echo '<pre>' . print_r(md5($arg), true) . '</pre>';
}

