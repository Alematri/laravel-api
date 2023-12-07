<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class project extends Model
{
    use HasFactory;
    // relazione con la tabella technologies
    // la funzione deve essere al singolare perché il project ha una sola categoria
    // a questa funzione accederò come proprietà della classe project
    public function technology(){
        return $this->belongsTo(technology::class);
    }

    // relazione many to many con la tabella types
    public function types(){
        return $this->belongsToMany(type::class)->withPivot('vote');
    }

    protected $fillable = [
        'title',
        'technology_id',
        'slug',
        'date',
        'text',
        'image',
        'image_original_name'
    ];
}

