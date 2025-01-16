<?php

function Debug($a)
{
    if(gettype($a) == 'integer'){
        echo $a;
    }
    if(gettype($a) == "string")
    {
        echo $a;
    }
    if(gettype($a) == 'array')
    {
        foreach($a as $b){
            echo $b;
            echo '<br>';
        }
    }
    echo '<br>';
}