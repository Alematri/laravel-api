<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class PageController extends Controller
{

    public function index(){
        $projects = project::with('technology','types')->paginate(20);

        return response()->json($projects);
    }

    public function getprojectBySlug($slug){
        //asperiores-dolores-recusandae-cum-nulla-dolores
        // query che mi prenda il project con lo slug passato
        $project = project::where('slug',$slug)->with('technology',)->first();
        if($project) $success = true;
        else $success = false;

        return response()->json(compact('project','success'));
    }


















    public function prova(){
        $user = [
            'name' => 'Ugo',
            'lastname' => 'De Ughi'
        ];
        $success = true;

        // non restituisco un view ma un file json
        return response()->json(compact('user','success'));
    }
}
