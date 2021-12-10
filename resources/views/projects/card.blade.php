<div class="shadow-lg rounded-xl w-72 md:w-96 p-4 bg-white overflow-hidden hover:bg-gray-100">
    <a href="{{$project->path()}}" class="w-full h-full block">
        <div class="flex items-center border-b-2 mb-2 py-2">
            <img class='w-10 h-10 object-cover rounded-full' alt='User avatar' src='{{$project->owner->avatar}}'>
            <div class="pl-3">
                <div class="font-medium">
                    {{$project->owner->name}}
                </div>
            </div>
        </div>
        <div class="w-full">
            <p class="text-gray-800 text-xl font-medium mb-2">
                {{$project->title}}
            </p>
            <p class="text-blue-600 text-xs font-medium mb-2">
                Zaktaulizoano: {{$project->updated_at->diffForHumans()}}
            </p>
            <p class="text-gray-400 text-sm mb-4">
                {{ Illuminate\Support\Str::limit($project->description, 100) }}
            </p>
        </div>
        <div class="flex items-center justify-between my-2">
            <p class="text-gray-500 text-sm">
                {{$project->tasks->where('status_id','=', 3)->count()}}/{{$project->tasks->count()}} zadań ukończonych
            </p>
        </div>
        <div class="relative pt-1">
            <div class="overflow-hidden h-2 text-xs flex rounded bg-blue-200">
                <div
                    style="
                            @if($project->tasks->count() === 0)
                                width: 0px
                            @else
                                width: {{$project->tasks->where('status_id','=', 3)->count() / $project->tasks->count() * 100 }}%
                            @endif
                    "
                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600 rounded-full"
                ></div>
            </div>
        </div>
        @can ('manage', $project)
                <footer class="mt-3">
                    <form method="POST" action="{{ $project->path() }}" class="text-right">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="button">Usuń</button>
                    </form>
                </footer>
        @endcan
    </a>
</div>




