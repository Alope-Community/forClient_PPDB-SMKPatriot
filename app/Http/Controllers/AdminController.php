<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Simple auth - ganti dengan database user di production
        if ($credentials['username'] === 'admin' && $credentials['password'] === 'ppdb123') {
            Session::put('admin_logged_in', true);
            Session::put('admin_username', 'Admin PPDB');
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $stats = [
            'total' => Pendaftaran::count(),
            'pending' => Pendaftaran::where('status', 'pending')->count(),
            'approved' => Pendaftaran::where('status', 'approved')->count(),
            'rejected' => Pendaftaran::where('status', 'rejected')->count(),
            'today' => Pendaftaran::whereDate('created_at', today())->count(),
        ];

        $recent = Pendaftaran::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }

    public function pendaftar(Request $request)
    {
        $pendaftar = Pendaftaran::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pendaftar.index', compact('pendaftar'));
    }

    public function show($id)
    {
        $pendaftar = Pendaftaran::findOrFail($id);
        return view('admin.pendaftar.show', compact('pendaftar'));
    }

    public function updateStatus(Request $request, $id)
    {
        // VALIDASI PENTING - Pastikan status ada dan valid
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $pendaftar = Pendaftaran::findOrFail($id);
        
        // Double check sebelum update
        $status = $request->input('status');
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 400);
        }

        $oldStatus = $pendaftar->status;
        $pendaftar->update(['status' => $status]);

        return redirect()->back();
    }
}