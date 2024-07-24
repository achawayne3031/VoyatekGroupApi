<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Validations\BlogValidator;
use App\Validations\ErrorValidation;
use App\Helpers\ResponseHelper;
use App\Models\Blog;
use App\Models\PostComments;
use App\Models\PostLikes;

use App\Models\Post;


use App\Helpers\DBHelpers;

class BlogController extends Controller
{
    //


    public function index(Request $request)
    {

      $blog = DBHelpers::data_paginate(Blog::class, 20);
    
        return ResponseHelper::success_response(
            'All blog fetched successfully',
            $blog
        );
     
    }



    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = BlogValidator::validate_rules($request, 'delete');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Blog::class, ['id' => $request->blog_id])){
                    return ResponseHelper::error_response(
                        'Blog not found',
                        [],
                        401
                    );
                }

                DBHelpers::delete_query_multi(Blog::class, ['id' => $request->blog_id]);

             

                if(DBHelpers::exists(Post::class, ['blog_id' => $request->blog_id])){
                    $posts = DBHelpers::where_query(Post::class, ['blog_id' => $request->blog_id]);
                    foreach ($posts as $value) {
                        # code...
                        DBHelpers::delete_query_multi(PostComments::class, ['post_id' => $value->id]);
                        DBHelpers::delete_query_multi(PostLikes::class, ['post_id' => $value->id]);
                    }
                    DBHelpers::delete_query_multi(Post::class, ['blog_id' => $request->blog_id]);
                }


            
                return ResponseHelper::success_response(
                    'Blog deleted successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['blog_id'];
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
            $validate = BlogValidator::validate_rules($request, 'update');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Blog::class, ['id' => $request->blog_id])){
                    return ResponseHelper::error_response(
                        'Blog not found',
                        [],
                        401
                    );
                }

               $blog = DBHelpers::query_filter_first(Blog::class, ['id' => $request->blog_id]);
               $update_data = [
                   'title' => $request->title ? $request->title : $blog->name,
                   'editor' => $request->editor ? $request->editor : $blog->editor,
                   'description' => $request->description ? $request->description : $blog->description,
                   'image_url' => $request->image_url ? $request->image_url : $blog->image_url,
               ];


               DBHelpers::update_query_v3(Blog::class, $update_data, ['id' => $request->blog_id]);
            
                return ResponseHelper::success_response(
                    'Blog updated successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['blog_id'];
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
            $validate = BlogValidator::validate_rules($request, 'view');

            if (!$validate->fails() && $validate->validated()) {

                if(!DBHelpers::exists(Blog::class, ['id' => $request->blog_id])){
                    return ResponseHelper::error_response(
                        'Blog not found',
                        [],
                        401
                    );
                }

                   
               $blog_data = Blog::find($request->blog_id);
               $blog_data->increment('total_views');
            

               $blog = DBHelpers::with_where_query_filter_first(Blog::class, ['post'], ['id' => $request->blog_id]);


            //   $blog = DBHelpers::query_filter_first(Blog::class, ['id' => $request->blog_id]);

            
                return ResponseHelper::success_response(
                    'Blog fetched successfully',
                    $blog
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['blog_id'];
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
            $validate = BlogValidator::validate_rules($request, 'create');

            if (!$validate->fails() && $validate->validated()) {
                DBHelpers::create_query(Blog::class, $request->all());
            
                return ResponseHelper::success_response(
                    'Blog created successfully',
                    null
                );

            } else {
                $errors = json_decode($validate->errors());
                $props = ['editor', 'title', 'image_url', 'description'];
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
