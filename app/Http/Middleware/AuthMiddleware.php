<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!session()->has('sheets_data')) {
            try {
                app(\App\Services\GoogleSheetsService::class)->preloadAllToSession();
            } catch (\Exception $e) {
                session()->forget('admin');
                return redirect()->route('login')->with('error', 'Gagal memuat data dari Google Sheets. Periksa koneksi internet.');
            }
        }

        return $next($request);
    }
}
