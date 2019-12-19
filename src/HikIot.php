<?php

namespace HikIot;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
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
     * @var array
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
                    'query' => $this->hik_api->getParams(),
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
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 初始化请求
     * @param $requests
     * @return HikIot
     * @throws InvalidApiException
     */
    public function initMultiRequest($requests)
    {
        $api_collection = [];
        foreach ($requests as $request) {
            if (!isset($request['request_name'])) {
                throw new \Exception('参数错误');
            }
            if (false === HikApiClassMap::getClassName($request['request_name']))
                throw new InvalidApiException($request['request_name']);
            $class_name = HikApiClassMap::getClassName($request['request_name']);

            $api = new $class_name;

            if (!empty($request['authorization'])) {
                $api->setReqAuth($request['authorization']);
            }
            if (!empty($request['request_params'])) {
                $api->setReqParams($request['request_params']);
            }
            $api_collection[] = $api;
        }
        $this->hik_api_collection = $api_collection;
        return $this;
    }

    /**
     * 发送请求
     * @param int $concurrency
     * @return array
     * @throws \Exception
     */
    public function sendMultiRequest(int $concurrency = 5)
    {
        if (empty($this->hik_api_collection)) {
            throw new \Exception('init requests before send');
        }
        if ($concurrency <= 0) {
            throw new \Exception('concurrency must be greater than 0');
        }

        $client = $this->guzzle_client;

        $requests = function () use ($client) {
            foreach ($this->hik_api_collection as $key => $api) {
                if (!$api instanceof HikRestApi) {
                    throw new \Exception('init requests before send');
                }
                $api->ready();
                $api->initUri();
                $api->initHeaders();
                yield function () use ($client, $api) {
                    return $client->requestAsync(
                        $api->method,
                        $api->uri,
                        [
                            'headers' => $api->headers,
                            'query' => $api->getParams(),
                        ]);
                };
            }
        };

        $result = [];
        $pool = new Pool($client, $requests(), [
            'concurrency' => $concurrency,
            'fulfilled' => function ($response, $index) use (&$result) {
                $result[$index] = json_decode($response->getBody()->getContents());
            },
            'rejected' => function ($reason, $index) use (&$result) {
                $response = $reason->getResponse();
                $status = $response->getStatusCode();
                if ($status == '401') {
                    $result[$index] = [
                        'code' => 401,
                        'message' => '授权过期'
                    ];
                } else {
                    $result[$index] = [
                        'code' => $status,
                    ];
                }
            },
        ]);

        // 开始发送请求
        $promise = $pool->promise();
        $promise->wait();

        return $result;
    }

}