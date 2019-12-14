<?php

namespace HikIot\RestApi\Groups;

use HikIot\RestApi\HikRestApi;

class GroupList extends HikRestApi
{
    protected $api = '/v2/groups/list';

    public $method = 'GET';
    public $header;

    protected $required_params = [
    ];

    protected $optional_params = [
    ];

    public function __construct()
    {
        parent::__construct();
    }

}