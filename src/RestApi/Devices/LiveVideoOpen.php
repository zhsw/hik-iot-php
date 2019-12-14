<?php

namespace HikIot\RestApi\Devices;

use HikIot\RestApi\HikRestApi;

class LiveVideoOpen extends HikRestApi
{
    protected $api = '/v1/devices/liveVideoOpen';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'channelIds' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}