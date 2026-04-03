<?php
$env = file(__DIR__.'/.env');

foreach($env as $line){

    if(trim($line)=='' || strpos($line,'=')===false){
        continue;
    }

    list($key,$value)=explode('=',trim($line),2);

    putenv("$key=$value");
}