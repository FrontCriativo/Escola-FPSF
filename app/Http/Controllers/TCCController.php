<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TCCController extends Controller
{
    public function index(): View
    {
        return view('tcc.index');
    }
}
