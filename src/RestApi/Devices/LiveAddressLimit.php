<?php

namespace HikIot\RestApi\Devices;

use HikIot\RestApi\HikRestApi;

class LiveAddressLimit extends HikRestApi
{
    protected $api = '/v1/devices/liveAddressLimit';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'deviceId' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}