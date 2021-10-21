@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="w-full flex justify-between items-end">
            <h1 class="text-gray-500 font-normal">Projekty</h1>
            <a href="/projects/create" class="button">Nowy projekt</a>
        </div>
    </header>
    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-2 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>Brak projektów</div>
        @endforelse
    </main>
@endsection
