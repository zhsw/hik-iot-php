<?php

namespace HikIot\RestApi\Devices;

use HikIot\RestApi\HikRestApi;

class LiveAddress extends HikRestApi
{
    protected $api = '/v1/devices/liveAddress';

    public $method = 'GET';
    public $header;

    protected $required_params = [
        'channelId' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}