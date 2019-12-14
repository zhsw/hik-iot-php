<?php

namespace HikIot\RestApi\Devices;

use HikIot\RestApi\HikRestApi;

class DeviceCount extends HikRestApi
{
    protected $api = '/v1/devices/count';

    public $method = 'GET';
    public $header;

    protected $required_params = [];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}