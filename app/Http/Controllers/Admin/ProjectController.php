<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use App\Http\Requests\PostRequest;
use App\Functions\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\Builder;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['toSearch'])) {
            $projects =  project::where('title', 'LIKE', '%'. $_GET['toSearch']. '%')->paginate(10);
        }else{
            $projects = project::orderBy('id', 'desc')->paginate(20);
        }

        $direction = 'desc';
        $toSearch = '';
        return view('admin.projects.index', compact('projects', 'direction','toSearch'));
    }

    public function orderBy($direction, $column){
        // in questo modo ogni volta che clicco inverto la direction
        $direction = $direction == 'desc'? 'asc' : 'desc';
        $projects = project::orderBy($column, $direction)->paginate(20);
        $toSearch = '';
        return view('admin.projects.index', compact('projects', 'direction', 'toSearch'));
    }

    public function search(Request $request){
        $toSearch = $request->toSearch;
        $projects = project::where('title', 'LIKE', '%'. $toSearch. '%')->paginate(20);
        $direction = 'desc';
        return view('admin.projects.index', compact('projects', 'toSearch','direction'));
    }

    public function notypes(){

        // faccio una ricerca dove ogni id della tabella project non è presente nella tabella project_type
        $projects = project::whereNotIn('id',function (Builder $query) {
                        $query->select('project_id')->from('project_type');
                    })->paginate(20);
        $direction = 'desc';
        return view('admin.projects.index', compact('projects', 'direction'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Inserimento nuovo project';
        $method = 'POST';
        $route = route('admin.projects.store');
        $project = null;
        $technologies = technology::all();
        $types = type::all();
        return view('admin.projects.create-edit', compact(
                                                'title',
                                                'method',
                                                'route',
                                                'project',
                                                'technologies',
                                                'types'
                                            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $form_data = $request->all();
        $form_data['slug'] = Helper::generateSlug($form_data['title'], project::class);
        $form_data['date'] = date('Y-m-d');

        // se esiste la chiave image salvo l'immagine nel file system e nel database
        if(array_key_exists('image', $form_data)) {

            // prima di salvare il file prendo il nome del file per salvarlo nel db
            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
            // salvo il file nello storage rinominandolo
            $form_data['image'] = Storage::put('uploads', $form_data['image']);

        }

        $new_project = project::create($form_data);

        // se trovo la chiave "types" significa che sono stati selezionati dei type
        // questa operazione la si fa dopo aver salvato il nuovo elemento nel db
        if(array_key_exists('types', $form_data)){
            $new_project->types()->attach($form_data['types']);
        }

        return redirect()->route('admin.projects.show', $new_project);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(project $project)
    {
        $title = 'Modifica project';
        $method = 'PUT';
        $route = route('admin.projects.update', $project);
        $technologies = technology::all();
        $types = type::all();
        return view('admin.projects.create-edit', compact(
                                                'title',
                                                'method',
                                                'route',
                                                'project',
                                                'technologies',
                                                'types'
                                            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, project $project)
    {
        $form_data = $request->all();
        if($form_data['title']!= $project->title){
            $form_data['slug'] = Helper::generateSlug($form_data['title'], project::class);
        }else{
            $form_data['slug'] = $project->slug;
        }

        if(array_key_exists('image', $form_data)){
            // se esiste la chiave image vuol dire che devo sostituire l'immagine presente (se c'è) eliminando quella vecchia
            if($project->image){
                Storage::disk('public')->delete($project->image);
            }

            // prima di salvare il file prendo il nome del file per salvarlo nel db
            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
            // salvo il file nello storage rinominandolo
            $form_data['image'] = Storage::put('uploads', $form_data['image']);
        }

        $form_data['date'] = date('Y-m-d');

        $project->update($form_data);

        if(array_key_exists('types', $form_data)){
            // aggiorno le relazioni tra i project e i type eliminando le eventuali relazioni che sono state tolte e aggiungendo le nuove
            //sync accetta un array creando tutte le relazioni tra i project e i type ed eliminando le eventuali relazioni che sono state tolte
            $project->types()->sync($form_data['types']);

        }else{
            // elimino tutte le relazioni tra i project e i type
            $project->types()->detach();
        }

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(project $project)
    {
        // non elimino le relazioni tra i project e i type perché nella migration ho messo cascadeOnDelete()
        // altrimenti avrei dovuto fare: $project->types()->detach();

        // se il project contiene una immagine vuol dire che la devo eliminare
        if($project->image){
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Il project è stato eliminato correttamente');


    }
}
