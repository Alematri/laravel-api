@extends('layouts.admin')

@section('content')

<h1>{{ $title }}</h1>

{{-- $errors->any() restituisce true se almeno un errore è presente nel form  --}}
@if($errors->any())
<div class="alert alert-danger" role="alert">
    <ul>
        {{-- $erroro->all() è una  funzione che restituisce tutti gli errori presenti nel form mettendoli in un array  --}}
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>

</div>
@endif



<div class="row">
    <div class="col-8">
        <form
          action="{{ $route }}"
          method="project"
          enctype="multipart/form-data"
        >
            @csrf
            @method($method)
            <div class="mb-3">
                <label for="title" class="form-label">Titolo project *</label>
                <input
                  id="title"
                  class="form-control @error('title') is-invalid @enderror"
                  name="title"
                  type="text"
                  value="{{ old('title', $project?->title) }}"
                >
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="technology_id" class="form-label">Categoria</label>
                 <select name="technology_id" class="form-select" id="technology_id" >
                        <option value="">Selezionare una categoria</option>
                    @foreach ($technologies as $technology)
                    {{--
                        sintassi alternativa per la selected:
                        {{ old('technology_id', $project?->technology_id) == $technology->id?'selected' : '' }} --}}
                        <option
                            value="{{ $technology->id }}"
                            @if ($technology->id === old('technology_id', $project?->technology?->id)) selected @endif
                            >{{ $technology->name }}</option>
                    @endforeach
                 </select>
            </div>

            <div class="mb-3">
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    @foreach ($types as $type )
                        <input
                          id="type_{{ $type->id }}"
                          class="btn-check"
                          autocomplete="off"
                          type="checkbox"
                          name="types[]"
                          value="{{ $type->id }}"

                            @if (($errors->any() && in_array($type->id, old('types',[])))
                                || (!$errors->any() && $project?->types->contains($type))
                                )
                                checked
                            @endif
                        >
                        <label class="btn btn-outline-primary" for="type_{{ $type->id }}">{{ $type->name }}</label>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Immagine</label>
                <input
                  id="image"
                  class="form-control @error('image') is-invalid @enderror"
                  name="image"
                  type="file"
                  onchange="showImage(event)"
                  value="{{ old('image', $project?->image) }}"
                >
                @error('image')
                    <p class="text-danger">{{ $image }}</p>
                @enderror
                {{-- in caso di errore del caricamento dell'immagine carico il placeholder  --}}
                <img id="thumb" width="150" onerror="this.src='/img/placeholder.png'"  src="{{ asset('storage/' . $project?->image) }}" />

            </div>
            <div class="form-floating mb-5">
                <textarea
                  id="text"
                  class="form-control"
                  name="text"
                  style="height: 200px"
                >{{ old('text',$project?->text)  }}</textarea>
                @error('text')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Invia</button>
            <button type="reset" class="btn btn-secondary">Annulla</button>

        </form>
    </div>
</div>
<script>
    ClassicEditor
        .create( document.querySelector( '#text' ) )
        .catch( error => {
            console.error( error );
        } );
    function showImage(event){
        const thumb = document.getElementById('thumb');
        thumb.src = URL.createObjectURL(event.target.files[0]);
    }
</script>


@endsection
