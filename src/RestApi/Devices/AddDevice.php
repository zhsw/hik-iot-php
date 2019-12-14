<?php

namespace HikIot\RestApi\Devices;

use HikIot\RestApi\HikRestApi;

class AddDevice extends HikRestApi
{
    protected $api = '/v1/devices/add';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'groupId' => '',
        'deviceSerial' => '',
        'validateCode' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}