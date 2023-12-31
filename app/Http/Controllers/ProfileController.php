<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManagerStatic as Image;




use App\Models\User;

class ProfileController extends Controller
{
    //

    public function view(User $user)
    {
        if (Gate::denies('same-user', $user)) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
        $user = User::find($user->id);
        return view('profile.show', compact('user'));

    }
    public function update(User $user, Request $request) {
        if (Gate::denies('same-user', $user)) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
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
                $path = public_path('images/profiles/' . $user->picture);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->extension();

            // Resize image
            $resizedImage = Image::make($image)->resize(150, 150);

            // Save resized image to public directory
            $resizedImage->save(public_path('images/profiles/' . $imageName));

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


    public function removePic (User $user) {
        if (Gate::denies('same-user', $user)) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        DB::transaction(function () use ($user) {
            if ($user->picture) {
                $path = public_path('images/profiles/' . $user->picture);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $user->picture = null;
            $user->save();
        });
        return redirect()->route('profile.view', $user)->with('success', 'Profile Picture deleted successfully!');

    }


}
