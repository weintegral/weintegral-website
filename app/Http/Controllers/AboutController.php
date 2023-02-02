<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function aboutAction()
    {
        return 'About Page';
    }

    public function servicesAction()
    {
        return 'Services Page';
    }

    public function clientsAction()
    {
        return 'Clients Page';
    }

    public function industriesAction()
    {
        return 'Industries that we serve Page';
    }
}
