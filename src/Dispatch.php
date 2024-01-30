<?php

namespace XxlJob;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Dispatch
{

    const HEADER = 'XXL-JOB-ACCESS-TOKEN';

    /**
     * @var string
     */
    private $server;

    /**
     * @var string
     */
    private $accessToken;

    public function __construct(string $server, string $accessToken)
    {
        $this->server = $server;
        $this->accessToken = $accessToken;
    }

    public function loopRegistry(string $registryKey, string $registryValue, int $loop = 60): void
    {
        while ($loop-- > 0) {
            $this->registry($registryKey, $registryValue);
            sleep(1);
        }
    }

    public function registry(string $registryKey, string $registryValue): bool
    {
        $url = "{$this->server}/api/registry";
        $body = [
            'registryGroup' => 'EXECUTOR',
            'registryKey' => $registryKey,
            'registryValue' => $registryValue,
        ];
        $guzzle = new Client();
        \think\facade\Log::info("执行器注册请求 url={$url} accessToken={$this->accessToken} body=" . json_encode($body));
        $respStr = $guzzle->post($url, [
            RequestOptions::JSON => $body,
            RequestOptions::HEADERS => [
                self::HEADER => $this->accessToken,
            ]
        ])
            ->getBody()
            ->getContents();
        \think\facade\Log::debug("执行器注册响应: {$respStr}");
       
        $response = Response::jsonUnserialize($respStr);
        if ($response->code == Response::SUCCESS_CODE) {
            \think\facade\Log::info('执行器注册成功');
            return true;
        } else {
            \think\facade\Log::error('执行器注册失败');
            return false;
        }
    }

    public function registryRmove(string $registryKey, string $registryValue){
        $url = "{$this->server}/api/registryRemove";
        $body = [
            'registryGroup' => 'EXECUTOR',
            'registryKey' => $registryKey,
            'registryValue' => $registryValue,
        ];
        $guzzle = new Client();
        \think\facade\Log::info("执行器取消注册请求 url={$url} accessToken={$this->accessToken} body=" . json_encode($body));
        $respStr = $guzzle->post($url, [
            RequestOptions::JSON => $body,
            RequestOptions::HEADERS => [
                self::HEADER => $this->accessToken,
            ]
        ])
            ->getBody()
            ->getContents();
        \think\facade\Log::debug("执行器取消注册响应: {$respStr}");

        $response = Response::jsonUnserialize($respStr);
        if ($response->code == Response::SUCCESS_CODE) {
            \think\facade\Log::info('执行器取消注册成功');
            return true;
        } else {
            \think\facade\Log::error('执行器取消注册失败');
            return false;
        }
    }
}