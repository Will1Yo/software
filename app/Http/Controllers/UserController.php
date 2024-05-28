<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    //
    public function index():View{
        $users = DB::table('users')->get();
        return view('index', ['users' =>$users]);
    }
}
