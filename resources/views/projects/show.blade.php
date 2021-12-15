@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="w-full flex justify-between items-end">
            <p class="text-gray-500 font-normal">
                <a href="/projects">Projekty</a> / {{$project->title}}
            </p>
            <div class="flex items-center">
                <a href="#"  @click.prevent="$modal.show('project-members')">
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
                </a>
                <a href="{{ $project->path().'/edit' }}" class="button ml-4">Edytuj Projekt</a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                        <h2 class="text-lg text-gray-500 font-normal mb-3">Zadania</h2>
                        <form action="{{$project->path()}}" class="p-3 mb-5 bg-blue-100 flex justify-between items-center" method="GET">
                            @csrf
                            <div>
                                <span class="m-3">Filtruj po osobie:</span>
                                <select name="sort_by_owner" id="sortBy">
                                    <option hidden disabled selected value> -- select an option -- </option>
                                    <option value="{{$project->owner->id}}">{{$project->owner->name}}</option>
                                    @foreach($project->members as $member)
                                        <option value="{{$member->id}}">{{$member->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <span class="m-3">Sortuj:</span>
                                <select name="sort_by_date" id="sortByOrder">
                                    <option value="desc">Od najnowszych</option>
                                    <option value="asc">Od najstarszych</option>
                                </select>
                            </div>

                            <div>
                                <span class="m-3">Filtru po statusie:</span>
                                <select name="sort_by_status" id="sortByUser">
                                    <option hidden disabled selected value> -- select an option -- </option>
                                    <option value="1"> Do zrobienia </option>
                                    <option value="2"> W toku </option>
                                    <option value="3"> Zrobione </option>
                                </select>
                            </div>
                            <div>
                                <button class="button" type="submit">Filtruj</button>
                            </div>
                        </form>
                    @foreach($tasks as $task)
                        <div class="bg-blue-200 d-inline px-3 py-2 font-medium text-lg flex">
                            <span class="mr-3">Przypisana osoba:</span>
                            <form action="{{ $task->path() . '/assignuser' }}" method="post" class="flex-1">
                                @method('PATCH')
                                @csrf
                                <select name="member" id="member" onchange="this.form.submit()" class="w-full">
                                    <option value="delete" {{(!$task->user_id) ? 'selected' : '' }}>Brak przypisanej osoby</option>
                                    <option value="{{$project->owner->id}}" {{($project->owner->id === $task->user_id) ? 'selected' : '' }}>{{$project->owner->name}}</option>
                                    @foreach($project->members as $member)
                                        <option value="{{$member->id}}" {{($member->id === $task->user_id) ? 'selected' : ''}}>{{$member->name}}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="card mb-9 flex {{($task->status_id === 3) ? 'border-2 border-green-600' : ''}}">
                            <form action="{{ $task->path() }}" method="post" class="w-full">
                                @method('PATCH')
                                @csrf
                                <div class="flex items-center">
                                    <input class="w-full focus:outline-none {{($task->status_id === 3) ? 'text-gray-400' : ''}}" type="text"
                                           name="body" value="{{$task->body}}" {{($task->status_id === 3) ? 'readonly="readonly"' : ''}}>
                                </div>
                            </form>

                            <form action="{{ $task->path() }} ./status" method="POST">
                                @method('PATCH')
                                @csrf
                                <select class="font-bold rounded-sm text-white p-2 mr-2 {{($task->status_id === 3) ? 'bg-green-600' : 'bg-blue-600'}}" name="status" id="status" onchange="this.form.submit()">
                                    @foreach($statuses as $status)
                                        <option
                                            class="bg-white text-black"
                                            value="{{$status->id}}" {{($status->id === $task->status_id)?'selected' : ''}}
                                        >{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </form>

                            <form action="{{ $task->path() . '/delete'}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="text" hidden value="{{$task->id}}">
                                <button class="bg-red-500 font-bold rounded-sm text-white p-2 mr-2 hover:bg-red-700" type="submit">Usuń</button>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks'}}" method="POST">
                            @csrf
                            <input placeholder="Dodaj zadanie.." class="w-full" name="body">
                        </form>
                    </div>
                    {!! $tasks->render() !!}
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
        <project-members-modal :project="{{$project}}" :user="{{auth()->user()}}"></project-members-modal>
    </main>
@endsection
