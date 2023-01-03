<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{   
    public function Show()
    {
        return view('home', ['posts' => Post::all()]);    
    }
}
