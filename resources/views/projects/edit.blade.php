@extends ('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="w-full flex justify-between items-end">
            <a href="{{ $project->path() }}" class="button float-right">Powrót</a>
        </div>
    </header>
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Edytuj projekt
        </h1>

        <form
            method="POST"
            action="{{ $project->path() }}"
        >
            @method('PATCH')

            @include ('projects.form', [
                'buttonText' => 'Zaktualizuj projekt'
            ])
        </form>
    </div>
@endsection
