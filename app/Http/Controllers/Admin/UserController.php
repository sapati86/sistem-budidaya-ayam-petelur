<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {

        $request->validate([
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role sendiri!');
        }

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Role user "' . $user->name . '" berhasil diubah menjadi ' . ucfirst($request->role) . '!');
    }
}