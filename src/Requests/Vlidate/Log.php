<?php

namespace XxlJob\Requests\Vlidate;

use think\Validate;

class Log extends  Validate
{
    protected $rule = [
            'logId' => 'required|number',
            'logDateTim' => 'number',
            'fromLineNum' =>'number',
        ];
}