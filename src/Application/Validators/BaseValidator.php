<?php
namespace Application\Validators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Interfaces\Exceptions\ValidationException;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Validation\Factory as ValidationFactory;

abstract class BaseValidator
{
    protected $validator;
    protected $mode;

    public function __construct()
    {
        $loader = new FileLoader(new Filesystem, base_path('/resources/lang'));
        $translator = new Translator($loader, 'en');
        $this->validator = new ValidationFactory($translator);
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function validate($data)
    {
        $rules = !empty($this->rules) ? $this->rules : [];
        $messages = !empty($this->messages) ? $this->messages : [];
        $attributes = !empty($this->attributes) ? $this->attributes : [];

        $addRuleWhenRequiredFound = function ($rulesList) {
            if (in_array('required', $rulesList)) {
                array_unshift($rulesList, 'sometimes');
            }
            return $rulesList;
        };

        if ($this->mode == 'update') {
            $rules = array_map($addRuleWhenRequiredFound, $rules);
        }

        if ($data instanceof DataTransferObject) {
            $data = $data->toArray();
        }

        $validation = $this->validator->make($data, $rules, $messages, $attributes);

        if ($validation->fails()) {
            throw new ValidationException($validation->messages());
        }

        return true;
    }
}
