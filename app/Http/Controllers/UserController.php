<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserList(Request $request)
    {
        $data = User::where('email', 'LIKE', '%' . $request->keyword . '%')->get();

        return response()->json($data);
    }
}
