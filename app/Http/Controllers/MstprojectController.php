<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mst_project;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class MstprojectController extends Controller
{
    public function index() {
        
        //$dataProvider = new EloquentDataProvider(mst_project::query());

        return view('mstproject.index', [
            'projects' => mst_project::all(), 
            //'dataProvider' => $dataProvider, 
        ]);
    }

    public function edit() {
        $id = '2caf310c-e135-11ec-a872-118771a3dc67';
        mst_project::query()->find($id)->update([
            'projectname' => 'update_hdaj',
        ]);
    }
}
