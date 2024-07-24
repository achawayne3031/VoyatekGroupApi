<?php

namespace App\Validations;
use App\Helpers\Func;

class PostLikeValidator
{
    protected static $validation_rules = [];

    public static function validate_rules($request, string $arg)
    {
        self::$validation_rules = [
            'create' => [
                'post_id' => 'required',
                'editor' => 'required',
            ],

        ];

        return Func::run_validation($request, self::$validation_rules[$arg]);
    }
}
