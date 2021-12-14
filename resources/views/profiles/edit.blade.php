@extends('layouts.app')

@section('content')
    <h2 class="text-2xl text-gray-900 my-5">Ustawienia</h2>
    <form method="POST" action="{{ $user->path() }}" enctype="multipart/form-data" class="card">
        @csrf
        @method('PATCH')

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                   for="name"
            >
                Nazwa
            </label>

            <input class="border border-gray-400 p-2 w-full rounded-lg"
                   type="text"
                   name="name"
                   id="name"
                   value="{{ $user->name }}"
                   required
            >

            @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                   for="username"
            >
                Nazwa użytkownika
            </label>

            <input class="border border-gray-400 p-2 w-full rounded-lg"
                   type="text"
                   name="username"
                   id="username"
                   value="{{ $user->username }}"
                   required
            >

            @error('username')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                   for="avatar"
            >
                Awatar
            </label>

            <div class="flex">
                <input class="border border-gray-400 p-2 w-full rounded-lg"
                       type="file"
                       name="avatar"
                       id="avatar"
                >

                <img src="{{ $user->avatar }}"
                     alt="your avatar"
                     width="40"
                     height="40"
                >
            </div>

            @error('avatar')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>


        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                   for="email"
            >
                Adre-Email
            </label>

            <input class="border border-gray-400 p-2 w-full rounded-lg"
                   type="email"
                   name="email"
                   id="email"
                   value="{{ $user->email }}"
                   required
            >

            @error('email')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                   for="password"
            >
                Hasło
            </label>

            <input class="border border-gray-400 p-2 w-full rounded-lg"
                   type="password"
                   name="password"
                   id="password"
            >

            @error('password')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                   for="password_confirmation"
            >
                Potwierdź hasło
            </label>

            <input class="border border-gray-400 p-2 w-full rounded-lg"
                   type="password"
                   name="password_confirmation"
                   id="password_confirmation"
            >

            @error('password_confirmation')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex justify-end">
            <button type="submit" class="button">
                Zapisz
            </button>
        </div>
    </form>
@endsection
