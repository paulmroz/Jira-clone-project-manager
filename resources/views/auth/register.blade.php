@extends('layouts.app')

@section('content')
    <div class="flex flex-col bg-gray-100">
        <div class="grid place-items-center mx-2 my-20 sm:my-auto">
            <div class="w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12
            px-6 py-10 sm:px-10 sm:py-6
            bg-white rounded-lg shadow-md lg:shadow-lg">

                <h2 class="text-center font-semibold text-3xl lg:text-4xl text-gray-800">
                    Zarejestruj się
                </h2>

                <form class="mt-10" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <label for="username" class="block text-xs font-semibold text-gray-600 uppercase">{{ __('Nazwa użytkownika') }}</label>
                        <input id="username" type="text" name="username" autocomplete="username" autofocus
                               class="block w-full py-3 px-1 mt-2
                        text-gray-800 appearance-none
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200
                        @error('username') border-red-900 @enderror"
                               required />

                        @error('username')
                        <span class="text-red-500" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-600 uppercase">{{ __('Imię i nazwisko') }}</label>
                        <input id="name" type="text" name="name" autocomplete="name" autofocus
                               class="block w-full py-3 px-1 mt-2
                        text-gray-800 appearance-none
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200
                        @error('name') border-red-900 @enderror"
                               required />

                        @error('name')
                        <span class="text-red-500" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-600 uppercase">{{ __('Adres e-Mail') }}</label>
                        <input id="email" type="email" name="email" autocomplete="email" autofocus
                               class="block w-full py-3 px-1 mt-2
                        text-gray-800 appearance-none
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200
                        @error('email') border-red-900 @enderror"
                               required />

                        @error('email')
                        <span class="text-red-500" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">{{ __('Hasło') }}</label>
                        <input id="password" type="password" name="password" autocomplete="current-password"
                               class="block w-full py-3 px-1 mt-2 mb-4
                        text-gray-800 appearance-none
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200
                        @error('password') border-red-900 @enderror"
                               required />

                        @error('password')
                        <span class="text-red-500" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label for="password-confirm"class="block mt-2 text-xs font-semibold text-gray-600 uppercase">{{ __('Powtórz hasło') }}</label>
                        <input id="password-confirm" type="password"  name="password_confirmation"  autocomplete="new-password"
                               class="block w-full py-3 px-1 mt-2 mb-4
                        text-gray-800 appearance-none
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200
                        @error('password') border-red-900 @enderror"
                               required />
                    </div>

                    <button type="submit"
                            class="w-full py-3 mt-10 bg-gray-800 rounded-sm
                    font-medium text-white uppercase
                    focus:outline-none hover:bg-gray-700 hover:shadow-none">
                        {{ __('Zarejestruj się') }}
                    </button>

                    <div class="sm:flex sm:flex-wrap mt-8 sm:mb-4 text-sm text-center">
                        <a href="{{ route('login') }}" class="flex-1 text-gray-500 text-md mx-4 my-1 sm:my-auto">
                            Zaloguj się
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
