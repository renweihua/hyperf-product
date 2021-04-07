<?php

declare(strict_types = 1);

namespace App\Request;

use App\Traits\Instance;
use Hyperf\Validation\Request\FormRequest;

class BaseRequest extends FormRequest
{
    use Instance;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [];
    }

    public function messages() : array
    {
        return [];
    }

    protected $scene = [

    ];

    public function getRules($scene = '') : array
    {
        // 如何设定为自动验证为false，则无需进行验证
        if ( !$this->authorize() ) return [];
        // 如何没有设定场景验证，那么返回所有的验证规则
        if ( empty($scene) ) return $this->rules();
        // 如果指定的场景存在，则返回该场景的规则
        if ( isset($this->scene[$scene]) ) return $this->getSceneRules($scene);
        // 场景不存在，则为空
        return [];
    }

    private function getSceneRules($scene)
    {
        $rules = [];
        $all_rules = $this->rules();
        foreach ($this->scene[$scene] as $rule) {
            $rules[$rule] = $all_rules[$rule];
        }
        return $rules;
    }

    public function getMessages($scene = '') : array
    {
        return $this->messages();
    }
}
