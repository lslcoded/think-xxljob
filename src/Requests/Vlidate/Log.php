<?php

namespace XxlJob\Requests\Vlidate;

use think\Validate;

class Log extends  Validate
{
    protected $rule = [
            'logId' => 'require',
            'logDateTim' => 'number',
            'fromLineNum' =>'number',
        ];
}
