<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(){
        // all this does is make sure you're logged in. It doesn't make sure that you own what you're trying to reach
        $this->middleware('auth');
    }
    public function index(){
        return redirect()->route('admin.dashboard');
    }
    public function dashboard(){
        return view('admin.dashboard');
    }
}

