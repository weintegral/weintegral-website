<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function indexAction()
    {
        return 'Career Page';
    }

    public function cultureAction()
    {
        return 'Work Culture Page';
    }

    public function benefitsAction()
    {
        return 'Benefits Page';
    }

    public function jobOpeningsAction()
    {
        return 'Current Job Openings Page';
    }
}
