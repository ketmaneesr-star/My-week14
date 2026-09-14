<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // app/Http/Controllers/HomeController.php
public function __construct()
{
    $this->middleware('auth');
}

public function index()
{
    return redirect('/');
}
}
