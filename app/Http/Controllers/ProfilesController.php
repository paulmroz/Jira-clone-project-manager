<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfilesController extends Controller
{
    public function edit(User $user)
    {
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'username' => [
                'string',
                'required',
                'max:255',
                'alpha_dash',
                Rule::unique('users')->ignore($user),
            ],
            'name' => ['string', 'required', 'max:255'],
            'avatar' => ['file', 'image', 'dimensions:min_width=100,min_height=200'],
            'email' => [
                'string',
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user),
            ],
            'password' => 'sometimes|nullable|alpha_num|between:6,20|confirmed'
        ]);

        $user->name = \request('name');
        $user->username = \request('username');
        $user->avatar = \request('avatar');
        $user->email = \request('email');
        $user->avatar = request('avatar')->store('avatars');

        if(null !== \request('password')) {
            $user->password = \request('password');
        }

        $user->save();

        return redirect($user->path('edit'));
    }
}
