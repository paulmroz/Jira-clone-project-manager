
<div class="card flex flex-col" style="height: 200px">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-500 pl-4 mb-3">
        <a href="{{$project->path()}}">{{$project->title}}</a>
    </h3>
    <div class="text-grey-300 mb-4 flex-1">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
    @can ('manage', $project)
        <footer>
            <form method="POST" action="{{ $project->path() }}" class="text-right">
                @method('DELETE')
                @csrf
                <button type="submit" class="text-xs">Delete</button>
            </form>
        </footer>
    @endcan
</div>

