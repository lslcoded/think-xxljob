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
        Log::info("执行器注册请求 url={$url} accessToken={$this->accessToken} body=" . json_encode($body));
        $respStr = $guzzle->post($url, [
            RequestOptions::JSON => $body,
            RequestOptions::HEADERS => [
                self::HEADER => $this->accessToken,
            ]
        ])
            ->getBody()
            ->getContents();
        Log::debug("执行器注册响应: {$respStr}");
       
        $response = Response::jsonUnserialize($respStr);
        if ($response->code == Response::SUCCESS_CODE) {
            Log::info('执行器注册成功');
            return true;
        } else {
            Log::error('执行器注册失败');
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
        Log::info("执行器取消注册请求 url={$url} accessToken={$this->accessToken} body=" . json_encode($body));
        $respStr = $guzzle->post($url, [
            RequestOptions::JSON => $body,
            RequestOptions::HEADERS => [
                self::HEADER => $this->accessToken,
            ]
        ])
            ->getBody()
            ->getContents();
        Log::debug("执行器取消注册响应: {$respStr}");

        $response = Response::jsonUnserialize($respStr);
        if ($response->code == Response::SUCCESS_CODE) {
            Log::info('执行器取消注册成功');
            return true;
        } else {
            Log::error('执行器取消注册失败');
            return false;
        }
    }


    public function callback(string $logId,string $logDateTim,int $handleCode = 200,string $handleMsg = ''){
        $url = "{$this->server}/api/callback";
        $body = [
            'logId' => $logId,
            'logDateTim' => $logDateTim ? intval($logDateTim) : 0,
            'handleCode' => $handleCode,
            'handleMsg' => $handleMsg,
        ];
        $guzzle = new Client();
        Log::info("任务回调 url={$url} accessToken={$this->accessToken} body=" . json_encode($body));
        $respStr = $guzzle->post($url, [
            RequestOptions::JSON => $body,
            RequestOptions::HEADERS => [
                self::HEADER => $this->accessToken,
            ]
        ])
            ->getBody()
            ->getContents();
        Log::debug("任务回调: {$respStr}");

        $response = Response::jsonUnserialize($respStr);
        if ($response->code == Response::SUCCESS_CODE) {
            Log::info('任务回调成功');
            return true;
        } else {
            Log::error('任务回调失败');
            return false;
        }
    }
    
}
