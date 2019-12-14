<?php

namespace HikIot\RestApi\Devices;

use HikIot\RestApi\HikRestApi;

class SetDeviceDefence extends HikRestApi
{
    protected $api = '/v1/devices/actions/setDefence';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'deviceId' => '',
        'isDefence' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}