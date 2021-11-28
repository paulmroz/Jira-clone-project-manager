<div class="card mt-3 w-72 md:w-96">
    <h1 class="mb-3">Dziennik aktywności:</h1>
    <ul class="text-xs list-reset">
        @foreach ($project->activity->slice(0, 15) as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }}">
                @include ("projects.activity.{$activity->description}")
                <span class="text-white bg-blue-600 rounded-full px-1">{{ $activity->created_at->diffForHumans(null, true) }}</span>
            </li>
        @endforeach
    </ul>
    <footer class="mt-5 text-right">
            <a href="{{$project->path() . '/activities'}}" class="button">Zobacz wszystkie</a>
    </footer>
</div>
