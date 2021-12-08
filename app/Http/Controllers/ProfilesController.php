<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilesController extends Controller
{
    public function edit(User $user)
    {
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {

        $this->prepareAvatar($user);

        request()->validate([
            'username' => [
                'string',
                'required',
                'max:255',
                'alpha_dash',
                Rule::unique('users')->ignore($user),
            ],
            'name' => ['string', 'required', 'max:255'],
            'avatar' => ['sometimes', 'file', 'image', 'dimensions:min_width=100,min_height=200'],
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
        $user->email = \request('email');

        if(null !== \request('password')) {
//            $user->password = \request('password');
            $user->password = Hash::make(\request('password'));
        }
        $user->save();

        return redirect($user->path('edit'));
    }

    /**
     * @param User $user
     */
    private function prepareAvatar(User $user): void
    {
        $oldAvatar = explode('/', $user->avatar)[5] ?? explode('/', $user->avatar)[4];

        if (
            \request()->has('avatar')
            && null !== \request('avatar')
        ) {
            $user->avatar = request('avatar')->store('avatars');
        } else {
            $user->avatar = 'avatars/' . $oldAvatar;
        }
    }
}
