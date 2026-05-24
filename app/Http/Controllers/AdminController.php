<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\CompressStat;
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
        /**
         * Statistik pendaftaran
         */
        $stats = [
            'total' => Pendaftaran::count(),
            'pending' => Pendaftaran::where('status', 'pending')->count(),
            'approved' => Pendaftaran::where('status', 'approved')->count(),
            'rejected' => Pendaftaran::where('status', 'rejected')->count(),
            'today' => Pendaftaran::whereDate('created_at', today())->count(),
        ];

        /**
         * Statistik compress image
         */
        $compress = CompressStat::first();

        // Jika belum ada data
        if (!$compress) {

            $compress = (object) [
                'original_size' => 0,
                'compressed_size' => 0,
                'total_files' => 0,
                'compression_ratio' => 0,
            ];
        }

        /**
         * Data terbaru
         */
        $recent = Pendaftaran::latest()->limit(5)->get();

        /**
         * Chart jurusan
         */
        $jurusanChart = Pendaftaran::selectRaw('kompetensi_keahlian, COUNT(*) as total')
            ->groupBy('kompetensi_keahlian')
            ->pluck('total', 'kompetensi_keahlian');

        return view('admin.dashboard', compact(
            'stats',
            'compress',
            'recent',
            'jurusanChart'
        ));
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
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $pendaftar = Pendaftaran::findOrFail($id);
        
        $status = $request->input('status');
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 400);
        }

        $oldStatus = $pendaftar->status;
        $pendaftar->update(['status' => $status]);

        return redirect()->back()->with('success', 'Mengubah Status Pendaftaran Berhasil!');;
    }
}