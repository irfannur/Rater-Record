<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatatController extends Controller
{
    public function index() {
  
        return view('catat/index', [
            'arr' => ['aa', 'bb', 'cc'], 
            'name' => 'sssss', 
        ]);
    }
}
