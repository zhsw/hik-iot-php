<?php

namespace HikIot\Exception;


class InvalidApiException extends \Exception
{
    public function __construct($api_name)
    {
        parent::__construct("api {$api_name} is not supported");
    }
}