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

                    @foreach($tasks as $task)
                        <div class="bg-blue-200 d-inline px-3 py-2 font-medium text-lg flex">

                            <span class="mr-3">Przypisana osoba:</span>
                            <form action="{{ $task->path() . '/assignuser' }}" method="post" class="flex-1">
                                @method('PATCH')
                                @csrf
                                <select name="member" id="member" onchange="this.form.submit()" class="w-full">
                                    @if(!$task->user_id)
                                        <option>Brak przypisanej osoby</option>
                                    @endif
                                        <option value="{{$project->owner->id}}">{{$project->owner->name}}</option>
                                    @foreach($project->members as $member)
                                        <option value="{{$member->id}}" {{($member->id === $task->user_id)? 'selected' : ''}}>{{$member->name}}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="card mb-3 {{($task->status_id === 3) ? 'border-2 border-green-600' : ''}}">
                            <form action="{{ $task->path() }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="flex items-center">
                                    <input class="w-full focus:outline-none {{($task->status_id === 3) ? 'text-gray-400' : ''}}" type="text"
                                           name="body" value="{{$task->body}}" {{($task->status_id === 3) ? 'readonly="readonly"' : ''}}>
                                    <select class="bg-blue-600 font-bold rounded-sm text-white p-2" name="status" id="status" onchange="this.form.submit()">
                                        @foreach($statuses as $status)
                                            <option
                                                class="bg-white text-black"
                                                value="{{$status->id}}" {{($status->id === $task->status_id)?'selected' : ''}}
                                            >{{$status->name}}</option>
                                        @endforeach
                                    </select>
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
        <project-members-modal :project="{{$project}}"></project-members-modal>
        <assign-user-modal></assign-user-modal>
    </main>
@endsection
