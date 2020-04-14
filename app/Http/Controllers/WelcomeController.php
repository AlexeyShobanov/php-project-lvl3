<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
