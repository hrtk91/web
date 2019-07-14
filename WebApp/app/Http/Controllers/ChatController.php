<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function readPosts()
    {
        $posts = \App\Post::all();
        return response()->Json($posts);
    }

    public function createPost(Request $req)
    {
        $post = \App\Post::create([
            'name' => $req->input('name'),
            'message' => $req->input('message')
        ]);
        $post->save();
        return;
    }
}
