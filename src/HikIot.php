<?php

namespace HikIot;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use HikIot\Exception\InvalidApiException;
use HikIot\RestApi\HikRestApi;

class HikIot
{
    private static $instance = null;

    /**
     * @var Client
     */
    private $guzzle_client = null;

    /**
     * @var HikRestApi
     */
    private $hik_api = null;

    /**
     * @var HikRestApi
     */
    private $hik_api_collection = null;

    private function __construct()
    {
        $this->guzzle_client = new Client([
            'verify' => false
        ]);
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 初始化请求
     * @param $request_name
     * @param $request_params
     * @param $authorization
     * @return HikIot
     * @throws InvalidApiException
     */
    public function initRequest($request_name, array $request_params = null, string $authorization = null)
    {
        if (false === HikApiClassMap::getClassName($request_name))
            throw new InvalidApiException($request_name);
        $class_name = HikApiClassMap::getClassName($request_name);

        $this->hik_api = new $class_name;

        if (!empty($authorization)) {
            $this->hik_api->setReqAuth($authorization);
        }
        if (!empty($request_params)) {
            $this->hik_api->setReqParams($request_params);
        }

        return $this;
    }

    /**
     * 发送请求
     * @throws \Exception
     */
    public function sendRequest()
    {
        if (!$this->hik_api instanceof HikRestApi) {
            throw new \Exception('init a request before send');
        }
        $this->hik_api->ready();

        $this->hik_api->initUri();
        $this->hik_api->initHeaders();

        try {
            $response = $this->guzzle_client->request(
                $this->hik_api->method,
                $this->hik_api->uri,
                [
                    'headers' => $this->hik_api->headers,
                    'form_params' => $this->hik_api->getParams(),
                ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response->getStatusCode() == '401') {
                return [
                    'code' => 401,
                    'message' => '授权过期'
                ];
            }
        }
        return $response->getBody()->getContents();
    }

    /**
     * 初始化请求
     */
    public function initMultiRequest()
    {
    }

    /**
     * 发送请求
     */
    public function sendMultiRequest()
    {
    }

}