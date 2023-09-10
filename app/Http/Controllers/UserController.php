<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

use App\Models\User;

class UserController extends Controller
{
    //
    public function index () {
        $users = User::get();
        $admins = $users->where('is_admin', '1');
        $normalUsers = $users->where('is_admin', '0');
        return view('users.index', compact('admins', 'normalUsers'));
    }


    public function destroy (User $user) {
        if (Gate::denies('same-user', $user) && Gate::denies('manage')){
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        try {
            $user = User::findOrFail($user->id);
            if ($user->is_admin == true) {
                return redirect()->route('users.index')->with('error', 'Admin cannot be deleted!');
            }
            $user->delete();
            if (Gate::allows('manage')) {
                return redirect()->route('users.index')->with('success', 'User deleted successfully!');
            } else {
                return redirect()->route('home')->with('success', 'Your account is deleted successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'An error occurred while deleting this user. Please try again.');
        }
    }
}
