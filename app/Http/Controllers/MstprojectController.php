<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mst_project;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class MstprojectController extends Controller
{
    public function index() {
        
        $dataProvider = new EloquentDataProvider(mst_project::query());

        return view('mstproject.index', [
            'projects' => mst_project::all(), 
            'dataProvider' => $dataProvider, 
        ]);
    }
}
