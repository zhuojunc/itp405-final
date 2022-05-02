<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $parties = $user->parties;       
        return view('profile.index', [
            'user' => Auth::user(),
            'parties' => $parties,
        ]);
    }
}
