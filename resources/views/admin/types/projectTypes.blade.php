
@extends('layouts.admin')

@section('content')

    <h1>Elenco progetti del tipo {{ $type->name }}</h1>

    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome progetto</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($type->projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>
                        <a class="btn btn-success" href="{{ route('admin.projects.show', $project) }}"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a>
                        @include('admin.partials.form-delete',[
                            'route' => route('admin.projects.destroy', $project),
                            'message' => 'Sei sicuro di voler eliminare questo project?'
                        ])
                    </td>

                </tr>
            @endforeach
        </tbody>
      </table>

@endsection

