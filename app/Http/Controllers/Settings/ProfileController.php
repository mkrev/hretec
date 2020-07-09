<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if ($request->hasFile('photo')) {
            $request->file('photo')->storeAs(
                "users/{$request->user()->name}",
                'photo.jpg',
                'public'
            );
        }

        return tap($user)->update(array_filter($request->only('email', 'ideology_id', 'economy_id', 'party_id')));
    }
}
