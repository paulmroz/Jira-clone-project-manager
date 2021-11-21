@if (count($activity->changes['after']) == 1)
    {{ $activity->user->name }} zaktualizował {{ key($activity->changes['after']) }} projektu
@else
   {{ $activity->user->name }} zaktualizował projekt
@endif
