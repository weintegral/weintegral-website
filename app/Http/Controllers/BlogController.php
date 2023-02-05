<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function indexAction(): View
    {
        return view('blog/index');
    }

    public function singleArticleAction(): View
    {
        return view('blog/index');
    }
}
