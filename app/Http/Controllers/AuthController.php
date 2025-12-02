<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{  
    public function showRegisterForm()
    {
        return view('auth.register');
    }   
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', 
            'password' => 'required|string|min:8|confirmed', 
        ],[
            'name.required' => 'Nama Harus Diisi!',
            'email.required' => 'Email Harus Diisi!',
            'email.email' => 'Format Email Salah!',
            'email.unique' => 'Email Sudah Terdaftar!',
            'password.required' =>'Password Harus Diisi!',
            'password.min' => 'Password Minimal 8 Karakter!',
            'password.confirmed' => 'Konfirmasi Password Salah!',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => 'calon_siswa', 
        ]);
        Auth::login($user);
        toast('Pendaftaran Berhasil!','success')->autoClose(3000);
        return redirect()->route('dashboard');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }   
    public function login(Request $request)
    {     
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' =>'Email Harus Diisi!',
            'email.email' => 'Format Email Salah!',
            'password.required' => 'Password Harus Diisi!',
        ]);
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
             toast('Berhasil Login!','success')->autoClose(3000);  
            return redirect()->intended('/dashboard');
        }
        Alert::error('Gagal Login', 'Email atau Password Salah')->autoClose(3000);
        return back(); 
    }
    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();
        toast('Berhasil Log Out!','success')->autoClose(3000);   
        return redirect('/');
    }
}