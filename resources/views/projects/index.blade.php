@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <h1 class="mr-auto">Projects</h1>
        <a href="/projects/create">Nowy projekt</a>
    </div>
    <ul>
        @forelse($projects as $project)
            <li>
                <a href="{{$project->path()}}"> {{$project->title}} </a>
            </li>
        @empty
            <li>Brak projektów</li>
        @endforelse
    </ul>
@endsection
