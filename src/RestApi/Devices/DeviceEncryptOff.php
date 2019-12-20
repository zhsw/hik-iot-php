<?php

namespace HikIot\RestApi\Devices;

use HikIot\RestApi\HikRestApi;

class DeviceEncryptOff extends HikRestApi
{
    protected $api = '/v1/devices/{deviceId}/encrypt/off';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'deviceId' => '',
        'validateCode' => '',
    ];

    protected $optional_params = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function initUri()
    {
        $this->api = preg_replace('/\\{deviceId\\}/', $this->request_params['deviceId'], $this->api);
        parent::initUri();
    }

    public function getParams()
    {
        return [
            'validateCode' => $this->request_params['validateCode']
        ];
    }

}