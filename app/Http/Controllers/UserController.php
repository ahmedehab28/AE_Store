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


    public function destroy ($id) {
        try {
            $user = User::findOrFail($id);
            if ($user->is_admin == true) {
                return redirect()->route('users.index')->with('error', 'Admin cannot be deleted!');
            }
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'An error occurred while deleting this user. Please try again.');
        }
    }
}
