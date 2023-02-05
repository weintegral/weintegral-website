<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagementController extends Controller
{
    public function teamAction(): View
    {
        return view('management/team');
    }

    public function contactAction(): View
    {
        return view('management/contact');
    }
}
