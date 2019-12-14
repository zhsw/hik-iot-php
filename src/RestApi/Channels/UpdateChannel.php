<?php

namespace HikIot\RestApi\Channels;

use HikIot\RestApi\HikRestApi;

class UpdateChannel extends HikRestApi
{
    protected $api = '/v1/channels/{channelId}/update';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'channelId' => '',
        'channelName' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

}