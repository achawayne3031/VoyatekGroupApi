<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Validations\PostCommentValidator;
use App\Validations\ErrorValidation;
use App\Helpers\ResponseHelper;
use App\Models\Post;
use App\Models\Blog;
use App\Models\PostComments;

use App\Helpers\DBHelpers;

class PostCommentController extends Controller
{
    //


    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostCommentValidator::validate_rules($request, 'create');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Post::class, ['id' => $request->post_id])){
                    return ResponseHelper::error_response(
                        'Post not found',
                        [],
                        401
                    );
                }

                DBHelpers::create_query(PostComments::class, $request->all());
            
                return ResponseHelper::success_response(
                    'Post comment created successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['editor', 'comment', 'post_id'];
                $error_res = ErrorValidation::arrange_error($errors, $props);
                return ResponseHelper::error_response(
                    'validation error',
                    $error_res,
                    401
                );
            }
        } else {
            return ResponseHelper::error_response(
                'HTTP Request not allowed',
                '',
                404
            );
        }

    }

}
