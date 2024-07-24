<?php

namespace App\Validations;
use App\Helpers\Func;

class BlogValidator
{
    protected static $validation_rules = [];

    public static function validate_rules($request, string $arg)
    {
        self::$validation_rules = [
            'create' => [
                'title' => 'required|unique:blog',
                'editor' => 'required',
                'description' => 'required',
                'image_url' => 'required',
            ],
            'view' => [
                'blog_id' => 'required',
            ],
            'delete' => [
                'blog_id' => 'required',
            ],
            'update' => [
                'blog_id' => 'required',
            ],

        ];

        return Func::run_validation($request, self::$validation_rules[$arg]);
    }
}
