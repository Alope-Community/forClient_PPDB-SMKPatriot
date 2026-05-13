<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('user.form-pendaftaran');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|size:10|unique:pendaftarans,nisn',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nomor_hp' => 'required|string|regex:/^08[0-9]{8,12}$/',
            'email' => 'required|email|unique:pendaftarans,email',
            'kompetensi_keahlian' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:8192',
            'mitra_pendaftaran' => 'nullable|string|max:255'
        ], [
            'nisn.size' => 'NISN harus 10 digit',
            'nomor_hp.regex' => 'Nomor HP harus berformat 08xxxxxxxxx',
            'pas_foto.max' => 'Ukuran foto maksimal 8MB',
            'nisn.unique' => 'NISN sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->except('pas_foto');
        
        if ($request->hasFile('pas_foto')) {
            $foto = $request->file('pas_foto');
            $filename = 'pasfoto_' . time() . '_' . $request->nisn . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('pas_foto', $filename, 'public');
            $data['pas_foto'] = $path;
        }

        Pendaftaran::create($data);

        return redirect()->back()->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi dari panitia.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
