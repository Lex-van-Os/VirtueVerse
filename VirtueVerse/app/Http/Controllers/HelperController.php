<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function getCsrfToken(Request $request) 
    {
        return csrf_token(); 
    }
}
