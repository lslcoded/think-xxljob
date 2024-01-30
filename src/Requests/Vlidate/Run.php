<?php

namespace XxlJob\Requests\Vlidate;

use think\Validate;

class Run extends  Validate
{
    protected $rule = [
        'jobId' => 'require|number',
        'executorHandler' =>'require',
        'executorTimeout' => 'number',
        'logId' =>'number',
        'logDateTime' => 'number',
        'glueUpdatetime' => 'number',
        'broadcastIndex' => 'number',
        'broadcastTotal' => 'number',
    ];
}