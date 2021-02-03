<?php
namespace Application\Validators;

use Domain\OS;
use Domain\Lang;
use Interfaces\Exceptions\ValidationException;

class DeviceValidator extends BaseValidator
{
    public $rules = [
        'u_id'=> ['required', 'string', 'max:100'],
        'app_id'=> ['required', 'string', 'max:100'],
        'lang'=> ['required', 'string', 'size:2'],
        'os'=> ['required', 'string'],
    ];
    public $attributes = [
        'u_id'=> 'uID',
        'app_id'=> 'appID',
        'language'=> 'lang',
    ];

    public function validate($data)
    {
        parent::validate($data);

        if (!in_array($data->lang, Lang::getISOList())) {
            throw new ValidationException('Language should be one of: '.implode(',', Lang::getISOList()));
        }

        if (!in_array($data->os, OS::getList())) {
            throw new ValidationException('OS should be one of: '.implode(',', OS::getList()));
        }

        return true;
    }

    public function sanitize($data)
    {
        if (!empty($data->u_id)) {
            $data->u_id = (string) $data->u_id;
        }
        if (!empty($data->app_id)) {
            $data->app_id = (string) $data->app_id;
        }
        if (!empty($data->lang)) {
            $data->lang = strtolower($data->lang);
        }
        if (!empty($data->os)) {
            $data->os = strtolower($data->os);
        }

        return $data;
    }
}
