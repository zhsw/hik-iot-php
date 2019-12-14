<?php

namespace HikIot\RestApi\Groups;

use HikIot\RestApi\HikRestApi;

class ChildrenGroupList extends HikRestApi
{
    protected $api = '/v2/groups/childrenList';

    public $method = 'GET';
    public $header;

    protected $required_params = [
    ];

    protected $optional_params = [
        'parentNo' => '',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}