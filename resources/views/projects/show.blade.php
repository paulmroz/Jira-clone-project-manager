@extends('layouts.app')

@section('content')
<h1>{{$project->title}}</h1>
<h2>{{$project->description}}</h2>
<a href="/projects">Powrót</a>
@endsection
