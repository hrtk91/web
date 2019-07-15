<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ChatApiController extends Controller
{
    public function index(Request $req) { return \App::Abort(404); }
    public function show(Request $req) { return \App::Abort(404); }
    public function create(Request $req)
    {
        $user = $req->user();

        $post = \App\Post::create([
            'name' => $user->name,
            'message' => $req->input('message')
        ]);
        $post->save();
        return;
    }

    public function read(Request $req)
    {
        $posts = \App\Post::all();
        return response()->Json($posts);
    }

    public function update(Request $req)
    {
        return;
    }

    public function delete(Request $req)
    {
        return;
    }
}
