@extends('layouts.admin')

@section('content')

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <h1>Elenco project</h1>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">
                <a href="{{ route('admin.order-by',['direction'=>$direction, 'column'=>'id']) }}">ID</a>
            </th>
            <th scope="col">
                <a href="{{ route('admin.order-by',['direction'=>$direction, 'column'=>'title']) }}">Titolo</a>
            </th>
            <th scope="col">
                <a href="{{ route('admin.order-by',['direction'=>$direction, 'column'=>'date']) }}">Data</a>
            </th>
            <th scope="col">Tecnologia</th>
            <th scope="col">Tipo</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->date }}</td>
                    <td>{{ $project->technology?->name ?? '-' }}</td>
                    <td>
                        @forelse ($project->types as $type)

                         <a
                           class="badge text-bg-info text-white text-decoration-none"
                           href="{{ route('admin.project-type', $type) }}"
                         >{{ $type->name }}</a> {{ $type->pivot->vote }}

                        @empty
                        <a
                        class="badge text-bg-info text-white text-decoration-none"
                        href="{{ route('admin.no-types') }}"
                      >Nessun Tipo</a>
                        @endforelse

                    </td>
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

      {{ $projects->links() }}
@endsection
