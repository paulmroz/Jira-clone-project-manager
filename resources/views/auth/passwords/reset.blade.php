@extends('layouts.app')

@section('content')
    <div class="flex flex-col bg-gray-100">
        <div class="grid place-items-center mx-2 my-20 sm:my-auto">
            <div class="w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12
                px-6 py-10 sm:px-10 sm:py-6
                bg-white rounded-lg shadow-md lg:shadow-lg">

                <h2 class="text-center font-semibold text-3xl lg:text-4xl text-gray-800">
                    Resetuj hasło
                </h2>

                <form class="mt-10"  method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-600 uppercase">Adres e-Mail</label>
                        <input id="email" type="email" name="email" autocomplete="email" autofocus value="{{ $email ?? old('email') }}"
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
                        <label for="password" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Hasło</label>
                        <input id="password" type="password" name="password" autocomplete="new-password"
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
                        <label for="password-confirm" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Powtórz hasło</label>
                        <input id="password-confirm" type="password" name="password_confirmation" autocomplete="new-password"
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
                        Resetuj hasło
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
