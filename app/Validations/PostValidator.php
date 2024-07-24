<?php

namespace App\Validations;
use App\Helpers\Func;

class PostValidator
{
    protected static $validation_rules = [];

    public static function validate_rules($request, string $arg)
    {
        self::$validation_rules = [
            'create' => [
                'blog_id' => 'required',
                'title' => 'required|unique:post',
                'editor' => 'required',
                'description' => 'required',
                'image_url' => 'required',
            ],
            'view' => [
                'post_id' => 'required',
            ],
            'delete' => [
                'post_id' => 'required',
            ],
            'update' => [
                'post_id' => 'required',
            ],
        ];

        return Func::run_validation($request, self::$validation_rules[$arg]);
    }
}
