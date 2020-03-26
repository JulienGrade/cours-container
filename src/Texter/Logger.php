<?php


namespace App\Texter;


class Logger
{
    public function log(string $message)
    {
        var_dump("LOGGER : $message");
    }
}