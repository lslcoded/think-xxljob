<?php

namespace XxlJob\Requests\Vlidate;

use think\Validate;

class Run extends  Validate
{
    protected $rule = [
        'jobId' => 'require',
        'executorHandler' =>'require',
        'executorTimeout' => 'number',
        'logId' =>'require',
        'logDateTime' => 'number',
        'glueUpdatetime' => 'number',
        'broadcastIndex' => 'number',
        'broadcastTotal' => 'number',
    ];
}
