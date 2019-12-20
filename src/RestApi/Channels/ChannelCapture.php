<?php

namespace HikIot\RestApi\Channels;

use HikIot\RestApi\HikRestApi;

class ChannelCapture extends HikRestApi
{
    protected $api = '/v1/channels/{channelId}/capture';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'channelId' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function initUri()
    {
        $this->api = preg_replace('/\\{channelId\\}/', $this->request_params['channelId'], $this->api);
        parent::initUri();
    }

    public function getParams()
    {
        return [];
    }

}