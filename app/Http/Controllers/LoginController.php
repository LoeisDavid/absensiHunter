<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if (session()->has('admin')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        try {
            $userModel = new UserModel();
            $user      = $userModel->findByUsername($request->username);

            if (!$user || $user['password'] !== $request->password) {
                return back()->with('error', 'Username atau password salah.')->withInput();
            }

            session(['admin' => [
                'id'    => $user['id'],
                'nama'  => $user['nama'],
                'role'  => $user['role'],
            ]]);

            // Preload Google Sheets data ke session
            app(\App\Services\GoogleSheetsService::class)->preloadAllToSession();

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke database. Periksa konfigurasi Google Sheets.')->withInput();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin');
        $request->session()->forget('sheets_data');
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
