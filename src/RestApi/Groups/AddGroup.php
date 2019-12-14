<?php

namespace HikIot\RestApi\Groups;

use HikIot\RestApi\HikRestApi;

class AddGroup extends HikRestApi
{
    protected $api = '/v2/groups/add';

    public $method = 'POST';
    public $header;

    protected $required_params = [
        'groupName' => '',
        'groupNo' => '',
    ];

    protected $optional_params = [
        'parentNo' => '',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}