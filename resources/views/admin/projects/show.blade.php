@php
    use App\Functions\Helper;
@endphp

@extends('layouts.admin')

@section('content')
    <h1>{{ $project->title }} <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a></h1>
    @if ($project->technology)
        <p>Categoria: <strong>{{ $project->technology->name }}</strong></p>
    @endif

    @forelse ($project->types as $type)
        <span class="badge text-bg-info">{{ $type->name }}</span>
    @empty
        <span class="badge text-bg-warning">Non sono presenti type</span>
    @endforelse


    <div class="w-50">
        <img class="img-fluid" src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
        <p>{{ $project->image_original_name }}</p>
    </div>
    <p>Data di creazione: {{ Helper::formatDate($project->date) }}</p>
    <p>{!! $project->text !!}</p>

@endsection

