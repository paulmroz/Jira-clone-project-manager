@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="w-full flex justify-between items-end">
            @if(count($projects) > 0)
                <h1 class="text-gray-500 font-normal">Projekty</h1>
                <a href="/projects/create" class="button float-right" @click.prevent="$modal.show('new-project')">Nowy projekt</a>
            @endif
        </div>
    </header>
    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-2 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div class="bg-white text-base rounded-lg shadow m-auto -brown-400 border border-black flex flex-col">
                <div class="p-4 flex flex-col">
                    <h3 type="element" class="text-4xl">Oops, wygląda na to że nie masz żadnych projektów.</h3>
                    <p type="element" class="my-4 m-auto">Kliknij w link poniżej i rozpocznij swoją przygodę z menadżerem projektów!</p>
                    <a
                        href="/projects/create" @click.prevent="$modal.show('new-project')"
                        class="text-white hover:bg-blue-500 bg-blue-400 m-auto my-4 px-6 py-2 text-lg rounded shadow-px-4 border-0">
                        Dodaj projekt
                    </a>
                </div>
            </div>
        @endforelse
    </main>
    {{ $projects->onEachSide(5)->links() }}
    <new-project-modal></new-project-modal>

@endsection
