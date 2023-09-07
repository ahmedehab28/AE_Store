<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
    //

    public function view($id) {
        if (auth()->id() !== $id) {
            abort(403, 'Unauthorized action.');
        }

        $user
    }
}
