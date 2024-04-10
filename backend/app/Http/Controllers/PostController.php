<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\PostTag;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        return response([
            "message" => "Get all posts success",
            "posts" => PostResource::collection(Post::latest()->get())
        ]);
    }

    public function show($id)
    {
        return response([
            'message' => "Get a post success", 
            "post" => new PostResource(Post::find($id))
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string|min:3|max:255",
            "body" => "required|min:3",
            "tags" => "array"
        ]);

        if ($validator->fails()) {
            return response([
                "message" => "Invalid fields!",
                "errors" => $validator->errors()
            ], 422);
        }

        $validated_data = $validator->validated();

        // post and slug creation
        $slug = strtolower($validated_data['title']);
        if (Post::where('slug', $slug)->exists()) {
            $all_same_slugs = Post::where('slug', "$slug%")->get();
            $slug = $slug . "-" . $all_same_slugs->count();
        }

        $post = Post::create([
            ...$validated_data,
            "slug" => $slug
        ]);

        // if post tags exist
        if ($request->has('tags')) {
            foreach ($request->tags as $tagname) {
                $tagslug = strtolower($tagname);
                $tag = Tag::where('slug', $tagslug)->get()->first();
                if (!$tag) {
                    $tag = Tag::create([
                        "name" => $tagname,
                        "slug" => $tagslug
                    ]);
                }

                PostTag::create([
                    "post_id" => $post->id,
                    "tag_id" => $tag->id
                ]);
            }
        }

        return response([
            "message" => "Create post success"
        ]);
    }
}
