<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->usertype == 'admin'){
        return view('admin.dashboard');
        }else {
           
            return redirect()->route('dashboard');
        }

    }
    
    public function home(Request $request)
    {
        if(Auth::user()->usertype == 'user'){
        return view('dashboard');
    }else {
        
        return redirect()->route('admin.dashboard');
    }
    }
    public function post(){
        return view('admin.post');
    }
    public function createpost(){
        return view('admin.createpost');
    }
    
}
