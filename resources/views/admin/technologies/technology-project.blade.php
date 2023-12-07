@extends('layouts.admin')

@section('content')


    <h1>Elenco categorie e project</h1>

    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Categoria</th>
            <th scope="col">project in relazione</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($technologies as $technology)
            <tr>
                 <td>{{ $technology->id }}</td>
                 <td>{{ $technology->name }}</td>
                 <td>
                    <ul class="list-group">
                        @foreach ($technology->projects as $project)
                            <li class="list-group-item">
                                <a href="{{ route('admin.projects.show', $project) }}">{{ $project->title }}</a>

                            </li>
                        @endforeach
                    </ul>
                 </td>

            </tr>
            @endforeach
        </tbody>
      </table>

@endsection
