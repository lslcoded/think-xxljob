<?php
namespace XxlJob\Requests\Think;

use XxlJob\Requests\Vlidate\Log;

class LogRequest extends \XxlJob\Requests\LogRequest
{
    /**
     * @return array
     */
    public function validate(): array
    {
        $validator = new Log();
        return $validator->batch(true)->check($this->toArray()) ? [] : $validator->getError();
    }
}