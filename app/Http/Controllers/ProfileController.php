<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;



use App\Models\User;

class ProfileController extends Controller
{
    //

    public function view(User $user)
    {
        if (Gate::denies('same-user', $user)) {
            abort(403, 'Unauthorized action.');
        }
        $user = User::find($user->id);
        return view('profile.show', compact('user'));

    }

    public function update(User $user, Request $request) {
        if (Gate::denies('same-user', $user)) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->hasFile('picture')) {
            // Picture update
            $validator = Validator::make($request->all(), [
                'picture' => 'nullable|image|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->route('profile.view', $user)
                    ->withErrors($validator)
                    ->with('error', 'There was a problem updating the profile picture.')
                    ->withInput();
            }

            if ($user->picture) {
                unlink(public_path('images/profiles/' . $user->picture));
            }
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/profiles'), $imageName);
            DB::beginTransaction();

            try {
                $user->update([
                    "picture" => $imageName,
                ]);
                DB::commit();

                return redirect()->route('profile.view', $user)->with('success', 'Profile picture updated successfully!');
            } catch (\Exception $e) {
                // Error handling
                DB::rollBack();
                File::delete(public_path('images/profiles/' . $imageName));
                return back()->with('error', 'There was a problem updating the profile picture: ' . $e->getMessage());
            }
        } else {
            // Rest of the form update
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->route('profile.view', $user)
                    ->withErrors($validator)
                    ->with('error', 'There was a problem updating the profile.')
                    ->withInput();
            }

            // Sanitization
            $name = strip_tags($request->name);
            $email = strip_tags($request->email); // using strip_tag to allow the ' char
            $address = filter_var($request->address, FILTER_SANITIZE_STRING);
            $phone = preg_replace('/[^0-9]/', '', $request->phone); // remove non-digit characters

            DB::beginTransaction();

            try {
                $user->update([
                    "name" => $name,
                    "email" => $email,
                    "address" => $address,
                    "phone" => $phone,
                ]);

                DB::commit();
                return redirect()->route('profile.view', $user)->with('success', 'Profile updated successfully!');
            } catch (\Exception $e) {
                // Error handling
                DB::rollBack();

                return back()->with('error', 'There was a problem updating the profile: ' . $e->getMessage());
            }
        }
    }

}
