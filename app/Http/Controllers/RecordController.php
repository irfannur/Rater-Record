<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index() {
  
        return view('record/index', [
            'arr' => ['aa', 'bb', 'cc'], 
            'name' => 'sssss', 
        ]);
    }
}
