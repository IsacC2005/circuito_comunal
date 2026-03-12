<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class InviteController extends Controller
{
    public function show(string $token)
    {
        $community = Community::where('invitation_token', $token)->first();

        if (! $community || $community->users()->exists()) {
            return view('invite.register', ['invalid' => true]);
        }

        return view('invite.register', [
            'invalid'   => false,
            'community' => $community,
            'token'     => $token,
        ]);
    }

    public function store(Request $request, string $token)
    {
        $community = Community::where('invitation_token', $token)->first();

        if (! $community || $community->users()->exists()) {
            return view('invite.register', ['invalid' => true]);
        }

        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole(Role::where('name', 'admin')->firstOrFail());

        $community->users()->attach($user);
        $community->update(['invitation_token' => null]);

        return redirect('/community/login')
            ->with('success', '¡Cuenta creada! Ya puedes iniciar sesión con tu comunidad.');
    }
}
