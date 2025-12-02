<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'calon_siswa') {
            return view('dashboard.calon_siswa_dashboard');
        }
        return redirect('/')->with('error', 'Role Anda tidak dikenali. Silakan hubungi admin.');
    }
}