<?php

namespace HikIot\RestApi\Groups;

use HikIot\RestApi\HikRestApi;

class GetGroup extends HikRestApi
{
    protected $api = '/v2/groups/{groupNo}/get';

    public $method = 'GET';
    public $header;

    protected $required_params = [
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
        $this->api = preg_replace('/\\{groupNo\\}/', $this->required_params['groupNo'], $this->api);
        parent::initUri();
    }

    public function getParams()
    {
        return [];
    }

}