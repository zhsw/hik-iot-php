<?php

namespace HikIot\RestApi\Channels;

use HikIot\RestApi\HikRestApi;

class ChannelList extends HikRestApi
{
    protected $api = '/v1/channels/list';

    public $method = 'GET';
    public $header;

    protected $required_params = [
        'deviceId' => '',
        'pageNo' => '',
        'pageSize' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}