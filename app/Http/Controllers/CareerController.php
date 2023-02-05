<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function indexAction(): View
    {
        return view('maintenance/pageUnderConstruction');
    }

    public function cultureAction(): View
    {
        return view('maintenance/pageUnderConstruction');
    }

    public function benefitsAction(): View
    {
        return view('maintenance/pageUnderConstruction');
    }

    public function jobOpeningsAction(): View
    {
        return view('maintenance/pageUnderConstruction');
    }
}
