<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Validations\PostLikeValidator;
use App\Validations\ErrorValidation;
use App\Helpers\ResponseHelper;
use App\Models\Post;
use App\Models\Blog;
use App\Models\PostComments;
use App\Models\PostLikes;


use App\Helpers\DBHelpers;

class PostLikeController extends Controller
{
    //


    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostLikeValidator::validate_rules($request, 'create');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Post::class, ['id' => $request->post_id])){
                    return ResponseHelper::error_response(
                        'Post not found',
                        [],
                        401
                    );
                }



                $post_data = Post::find($request->post_id);
                $post_data->increment('total_likes');

                DBHelpers::create_query(PostLikes::class, $request->all());
            
                return ResponseHelper::success_response(
                    'Post like was successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['editor', 'post_id'];
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
