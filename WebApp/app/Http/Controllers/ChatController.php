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
        return view('index');
    }

    public function read(int $id = 1)
    {
        $posts = \App\Post::where('channelId', $id)->get();
        return response()->Json($posts);
    }

    public function create(Request $req)
    {
        \Log::debug($req);
        $user = $req->user();

        $post = \App\Post::create([
            'name' => $user->name,
            'message' => $req->input('message'),
            'channelId' => $req->input('channelId')
        ]);
        $post->save();
        return;
    }

    public function user(Request $req)
    {
        return $req->user();
    }

    public function channels(Request $req)
    {
        $channels = \App\Channel::all();
        return response()->json($channels);
    }

    public function addChannel(Request $req)
    {
        $channelName = $req->input('channelName');
        \Log::debug($req);
        $channel = \App\Channel::create([
            'name' => $channelName
        ]);
        $channel->save();
        return;
    }

    public function deleteChannel(int $id)
    {
        \App\Channel::where(['id' => $id])->delete();
        return;
    }
}
