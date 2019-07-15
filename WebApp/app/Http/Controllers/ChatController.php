<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('index', ['api_token' => \Auth::user()->api_token ?? 'dame']);
    }

    public function read()
    {
        $posts = \App\Post::all();
        return response()->Json($posts);
    }

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
}
