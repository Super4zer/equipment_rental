<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('admin.dashboard');
        } elseif ($user->isPetugas()) {
            return view('petugas.dashboard');
        } else {
            // Redirect peminjam to browse page
            return redirect()->route('peminjam.browse');
        }
    }
}
