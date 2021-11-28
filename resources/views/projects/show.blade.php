@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="w-full flex justify-between items-end">
            <p class="text-gray-500 font-normal">
                <a href="/projects">Projekty</a> / {{$project->title}}
            </p>
            <div class="flex items-center">
                <div class="flex items-center overflow-hidden mt-2">
                    @foreach ($project->members as $member)
                        @if ($loop->first)
                            <img
                                src="{{ $member->avatar }}"
                                alt="{{ $member->name }}'s avatar"
                                class="inline-block h-11 w-11 rounded-full text-white border-2 border-white object-cover object-center">
                        @else
                            <img
                                src="{{ $member->avatar }}"
                                alt="{{ $member->name }}'s avatar"
                                class="-ml-2 inline-block h-11 w-11 rounded-full text-white border-2 border-white object-cover object-center">
                        @endif
                    @endforeach
                        <img
                            src="{{ $project->owner->avatar }}"
                            alt="{{ $project->owner->name }}'s avatar"
                            class="rounded-full w-12 h-12 mr-2 border-2 border-red-500">
                </div>
                <a href="{{ $project->path().'/edit' }}" class="button ml-4">Edytuj Projekt</a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-500 font-normal mb-3">Zadania</h2>

                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input class="w-full border-0 {{$task->completed ? 'text-gray-400' : ''}}" type="text"
                                           name="body" value="{{$task->body}}">
                                    <input type="checkbox" name="completed"
                                           onchange="this.form.submit()" {{ $task->completed ? 'checked': ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks'}}" method="POST">
                            @csrf
                            <input placeholder="Dodaj zadanie.." class="w-full" name="body">
                        </form>
                    </div>

                </div>
                <div>
                    <h2 class="text-lg text-gray-500 font-normal mb-3">Notatki</h2>
                    <form action="{{$project->path()}}" method="post">
                        @csrf
                        @method('PATCH')
                        <textarea class="card w-full mb-4" name="notes">{{$project->notes}}</textarea>
                        <div>
                            <button type="submit" class="button">Zapisz</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="lg:w-1/4 px-3 mt-10">
                @include('projects.card')
                @include ('projects.activity.card')

                @can ('manage', $project)
                    @include ('projects.invite')
                @endcan
            </div>
        </div>
    </main>
@endsection
