@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="w-full flex justify-between items-end">
            <h1 class="text-gray-500 font-normal text-3xl">Wszystkie aktywyności:</h1>
            <a href="{{$activities[0]->project->path()}}" class="button float-right">Powrót</a>
        </div>
    </header>
    <table class="border-4 border-black w-100">
        @foreach ($activities as $activity)
            <div class="flex justify-between mt-3 mb-3">
                <div>
                    @include ("projects.activity.{$activity->description}")
                </div>
                <div>
                    <span class="text-white bg-blue-600 rounded-full px-3 py-2">{{ $activity->created_at->toDateTimeString() }}</span>
                </div>
            </div>
            <hr>
        @endforeach
    </table>
    {{ $activities->links() }}
@endsection
