<?php

namespace HikIot\RestApi;



class HikRestApi
{
    protected $api = '/';
    protected $host = 'https://api2.hik-cloud.com';

    public $authorization;

    public $method;
    public $uri;
    public $headers;
    public $request_params = [];

    protected $required_params = [];
    protected $optional_params = [];

    public function __construct()
    {
    }

    /**
     * 设置请求access_token
     * @param $authorization
     */
    public function setReqAuth($authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * 设置请求参数
     * @param string|array $key
     * @param string|int $value
     */
    public function setReqParams($key, $value = null)
    {
        if (!is_array($key)) {
            $this->setReqParam($key, $value);
        }
        foreach ($key as $real_key => $value) {
            $this->setReqParam($real_key, $value);
        }
    }

    /**
     * 检查请求参数
     * @param string $key
     * @param string $value
     */
    private function setReqParam(string $key, string $value)
    {
        // 参数通用检查规则
        $this->generalCheckReqParam($key, $value);

        // 参数专用检查规则
        $check_func = 'checkReq' . $key;
        if (method_exists($this, $check_func)) {
            $this->$check_func($value);
        }

        $this->request_params[$key] = $value;
    }

    /**
     * 参数通用检查规则
     * @param string $key
     * @param $value
     */
    private function generalCheckReqParam(string $key, $value)
    {
        if (!isset($this->required_params[$key]) && !isset($this->optional_params[$key])) {
            throw new \InvalidArgumentException("unexpected request parameter [{$key}]");
        }
        if ($value === '' || $value === null) {
            throw new \InvalidArgumentException("parameter [{$key}] cannot be empty");
        }
    }

    /**
     * 请求准备完成
     */
    public function ready()
    {
        foreach ($this->required_params as $key => $param) {
            if (!isset($this->request_params[$key])) {
                throw new \InvalidArgumentException("missed request parameter [{$key}]");
            }
        }
    }

    public function initHeaders()
    {
        if (empty($this->authorization)) {
            throw new \InvalidArgumentException('expected access token!');
        }
        $this->headers = [
            "Host" => "api2.hik-cloud.com",
            "Content-Type" => "application/x-www-form-urlencoded; charset=utf-8",
            "Authorization" => "bearer {$this->authorization}",
        ];
    }

    public function initUri()
    {
        $this->uri = $this->host . $this->api;
    }

    public function getParams()
    {
        return $this->request_params;
    }
}