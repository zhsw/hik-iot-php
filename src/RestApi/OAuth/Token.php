<?php

namespace HikIot\RestApi\OAuth;

use HikIot\RestApi\HikRestApi;

class Token extends HikRestApi
{
    protected $api = '/oauth/token';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'client_id' => '',
        'client_secret' => '',
        'grant_type' => '',
    ];

    protected $optional_params = [
        'scope' => '',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function initHeaders()
    {
        $this->header = [
            "Host" => "api2.hik-cloud.com",
            "Content-Type" => "application/x-www-form-urlencoded"
        ];
    }

}