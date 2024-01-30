<?php

namespace XxlJob\Controller;

use think\facade\Request;
use think\route\dispatch\Controller;
use XxlJob\ExecutorBiz;

class ThinkController extends    Controller
{

    /**
     * @var ExecutorBiz
     */
    private $executorBiz;

    public function __construct(ExecutorBiz $executorBiz)
    {
        $this->executorBiz = $executorBiz;
    }

    public function beat(Request $request): string
    {
        return json_encode($this->executorBiz->beat());
    }

    public function idleBeat(Request $request): string
    {
        return json_encode($this->executorBiz->idleBeat($this->safeGetJobId($request)));
    }

    public function run(RunRequest $request): string
    {
        return json_encode($this->executorBiz->run($request));
    }

    public function kill(Request $request): string
    {
        return json_encode($this->executorBiz->kill($this->safeGetJobId($request)));
    }

    public function log(LogRequest $request): string
    {
        return json_encode($this->executorBiz->log($request));
    }

    /**
     * 获取jobId
     * @param Request $request
     * @return int
     */
    private function safeGetJobId(Request $request): int
    {
        return intval($request->input('jobId', 0));
    }
}