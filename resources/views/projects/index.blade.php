@extends('layouts.app')
@section('search')
    <div class="relative mx-auto text-gray-600 mr-2">
        <form action="/projects" method="GET">
            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
               type="search" name="search" placeholder="Search">
        </form>
        <button type="submit" class="absolute right-0 top-0 mt-3 mr-3">
            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                 viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                 width="512px" height="512px">
            <path
                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
          </svg>
        </button>
    </div>
@endsection
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
            <div class="bg-white text-base rounded-lg shadow m-auto -brown-400 shadow-2xl flex flex-col">
                <div class="p-4 flex flex-col">
                    <h3 type="element" class="text-4xl">Oops, wygląda na to że nie masz żadnych projektów.</h3>
                    <p type="element" class="my-4 m-auto">Kliknij w przycisk poniżej i rozpocznij swoją przygodę z menadżerem projektów!</p>
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
