<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Validations\PostValidator;
use App\Validations\ErrorValidation;
use App\Helpers\ResponseHelper;
use App\Models\Post;
use App\Models\Blog;
use App\Helpers\DBHelpers;

class PostController extends Controller
{
    //


    public function index(Request $request)
    {

      $post = DBHelpers::data_paginate(Post::class, 20);
    
        return ResponseHelper::success_response(
            'All post fetched successfully',
            $post
        );
     
    }



    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostValidator::validate_rules($request, 'delete');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Post::class, ['id' => $request->post_id])){
                    return ResponseHelper::error_response(
                        'Post not found',
                        [],
                        401
                    );
                }

                DBHelpers::delete_query_multi(Post::class, ['id' => $request->post_id]);
            
                return ResponseHelper::success_response(
                    'Post deleted successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['post_id'];
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




    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostValidator::validate_rules($request, 'update');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Post::class, ['id' => $request->post_id])){
                    return ResponseHelper::error_response(
                        'Post not found',
                        [],
                        401
                    );
                }

               $post = DBHelpers::query_filter_first(Post::class, ['id' => $request->post_id]);

               $update_data = [
                   'title' => $request->title ? $request->title : $post->name,
                   'editor' => $request->editor ? $request->editor : $post->editor,
                   'description' => $request->description ? $request->description : $post->description,
                   'image_url' => $request->image_url ? $request->image_url : $post->image_url,
               ];


               DBHelpers::update_query_v3(Post::class, $update_data, ['id' => $request->post_id]);
            
                return ResponseHelper::success_response(
                    'Post updated successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['post_id'];
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



    public function view(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostValidator::validate_rules($request, 'view');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Post::class, ['id' => $request->post_id])){
                    return ResponseHelper::error_response(
                        'Post not found',
                        [],
                        401
                    );
                }

                $post_data = Post::find($request->post_id);
                $post_data->increment('total_views');

                $post = DBHelpers::with_where_query_filter_first(Post::class, ['blog', 'post_comment', 'post_like'], ['id' => $request->post_id]);

                return ResponseHelper::success_response(
                    'Post fetched successfully',
                    $post
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['post_id'];
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



    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = PostValidator::validate_rules($request, 'create');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Blog::class, ['id' => $request->blog_id])){
                    return ResponseHelper::error_response(
                        'Blog not found',
                        [],
                        401
                    );
                }

                DBHelpers::create_query(Post::class, $request->all());
            
                return ResponseHelper::success_response(
                    'Post created successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['editor', 'title', 'image_url', 'description', 'blog_id'];
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
