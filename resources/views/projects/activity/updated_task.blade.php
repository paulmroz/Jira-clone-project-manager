@if (count($activity->changes['after']) == 1)
    @if(key($activity->changes['after']) === 'deleted')
        <span class="text-white bg-red-600 rounded-full px-2">{{ $activity->user->name }} usunął zadanie</span>
    @else
        <span class="text-white bg-green-300 rounded-full px-2">{{ $activity->user->name }} zaktualizował {{ key($activity->changes['after']) }} zadania</span>
    @endif
@else
    <span class="text-white bg-green-300 rounded-full px-2">{{ $activity->user->name }} zaktualizował zadanie</span>
@endif
