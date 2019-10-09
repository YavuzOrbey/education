<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function index(){
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user){
        return view('admin.users.show', compact('user'));
    }
}
