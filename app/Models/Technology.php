<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class technology extends Model
{
    use HasFactory;
    // relazione con la tabella projects
    // creo una funzione col nome della tabella e all'intenrno definisco l'apparteneza
    // ogni categoria ha tanti project
    // a questa funzione accederò come proprietà della classe technology
    public function projects(){
        return $this->hasMany(project::class);
    }

    protected $fillable = [
        'name','slug'
    ];
}
