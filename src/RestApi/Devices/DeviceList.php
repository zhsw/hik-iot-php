<?php

namespace HikIot\RestApi\Devices;

use HikIot\RestApi\HikRestApi;

class DeviceList extends HikRestApi
{
    protected $api = '/v1/devices/list';

    public $method = 'GET';
    public $header;

    protected $required_params = [
        'groupId' => '',
        'pageNo' => '',
        'pageSize' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}