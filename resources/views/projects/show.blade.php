@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="w-full flex justify-between items-end">
            <p class="text-gray-500 font-normal">
                <a href="/projects">Projekty</a> / {{$project->title}}
            </p>
            <a href="/projects/create" class="button">Nowy projekt</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-500 font-normal mb-3">Zadania</h2>

                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            {{$task->body}}
                        </div>
                    @endforeach

                </div>
                <div>
                    <h2 class="text-lg text-gray-500 font-normal mb-3">Notatki</h2>
                    <textarea class="card w-full" style="min-height: 200px">
                    </textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>
@endsection
