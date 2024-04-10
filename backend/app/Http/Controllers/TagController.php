<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(){
        return response([
            "message" => "Get all tags success",
            "tags" => Tag::all()
        ]);
    }

    public function show($slug){
        $tag = Tag::where('slug', $slug)->first();

        if(!$tag){
            return response([
                "message" => "Tag not found!",
            ], 404);
        }

        return response([
            "message" => "Get tag success",
            "tag" => $tag,
            "posts" => PostResource::collection($tag->posts)
        ]);
    }
}
