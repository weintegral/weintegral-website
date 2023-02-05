<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function aboutAction(): View
    {
        return view('about/index');
    }

    public function servicesAction(): View
    {
        return view('about/services');
    }

    public function clientsAction(): View
    {
        return view('about/clients');
    }

    public function industriesAction(): View
    {
        return view('about/industries');
    }
}
