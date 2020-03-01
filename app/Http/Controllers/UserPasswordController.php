<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordsRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserPasswordController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(): View
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        return view('users.password', ['user' => $user]);
    }

    /**
     * Update password for the specified resource in storage.
     */
    public function update(UserPasswordsRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $request->merge([
            'password' => Hash::make($request->input('password'))
        ]);

        $user->update($request->only('password'));
        $user->password_changed_at = Carbon::now();
        $user->save();

        return redirect()->route('home')->withSuccess(__('users.password_updated'));
    }
}
