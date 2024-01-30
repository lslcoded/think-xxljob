<?php
namespace XxlJob\Requests\Think;

use think\Validate;
use XxlJob\Requests\Vlidate\Run;

class RunRequest extends \XxlJob\Requests\RunRequest
{
    /**
     * @return array
     */
    public function validate(): array
    {
        $validator = new Run();
        return $validator->batch(true)->check($this->toArray()) ? [] : $validator->getError();
    }
}