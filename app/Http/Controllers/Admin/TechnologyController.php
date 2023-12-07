<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\technology;
use Illuminate\Support\Str;
use App\Functions\Helper;

class technologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = technology::all();
        return view('admin.technologies.index', compact('technologies'));
    }

    public function technologyproject(){
        $technologies = technology::all();
        return view('admin.technologies.technology-project', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // prima di creare una nuova categoria verifichiamo se esiste già
        // se esiste non creo la nuova categoria ma ritorno alla index con un messaggio di errore
        $exixts = technology::where('name', $request->name)->first();
        if($exixts){
            return redirect()->route('admin.technologies.index')->with('error', 'Categoria già presente');
        }else{
            $new_technology = new technology();
            $new_technology->name = $request->name;
            $new_technology->slug = Helper::generateSlug($request->name, technology::class);
            $new_technology->save();
            return redirect()->route('admin.technologies.index')->with('success', 'Categoria  creata con successo');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, technology $technology)
    {
        /*
            1. Validare il dato
            2. Controllarre se esiste una categoria con lo stesso nome
            3. Generare lo slug
            4. Effettuare l'update
            5. Reindirizzare alla index
        */

        // 1.
        $val_data = $request->validate([
            'name' => 'required|min:2|max:20',
        ],[
            'name.required' => 'Devi inserire il nome della categoria',
            'name.min' => 'Il nome della categoria deve essere minimo 2 caratteri',
            'name.max' => 'Il nome della categoria deve essere massimo 20 caratteri'
        ]);

        // 2.
        $exixts = technology::where('name', $request->name)->first();
        if($exixts){
            return redirect()->route('admin.technologies.index')->with('error', 'Categoria già presente');
        }

        // 3.
        $val_data['slug'] = Helper::generateSlug($request->name, technology::class);

        // 4.
        $technology->update($val_data);

        // 5.
        return redirect()->route('admin.technologies.index')->with('success', 'Categoria aggiornata con successo');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(technology $technology)
    {
        $technology->delete();
        return redirect()->route('admin.technologies.index')->with('success', 'Categoria eliminata con successo');
    }
}
