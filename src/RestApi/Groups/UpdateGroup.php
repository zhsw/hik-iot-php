<?php

namespace HikIot\RestApi\Groups;

use HikIot\RestApi\HikRestApi;

class UpdateGroup extends HikRestApi
{
    protected $api = '/v2/groups/{groupNo}/update';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'groupName' => '',
        'groupNo' => '',
    ];

    protected $optional_params = [
    ];

    public function __construct()
    {
        parent::__construct();
    }


    public function initUri()
    {
        $this->api = preg_replace('/\\{groupNo\\}/', $this->request_params['groupNo'], $this->api);
        parent::initUri();
    }

    public function getParams()
    {
        return [
            'groupName' => $this->request_params['groupName']
        ];
    }

}