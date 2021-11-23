@if (count($activity->changes['after']) == 1)
    <span class="text-white bg-yellow-500 rounded-full px-2">{{ $activity->user->name }} zaktualizował {{ key($activity->changes['after']) }} projektu</span>
@else
    <span class="text-white bg-yellow-500 rounded-full px-2">{{ $activity->user->name }} zaktualizował projekt</span>
@endif
