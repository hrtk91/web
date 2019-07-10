<?php

namespace App\Http\Controllers;

use App\User; //Userモデルを呼び出す
class UserController extends Controller
{
    public function index()
    {
       $user = User::where('name','テスト')->firstOrFail();
 
       dd($user->name); // nameの値をデバッグ

       echo $user->name;
    }
}