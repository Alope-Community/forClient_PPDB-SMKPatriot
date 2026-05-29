@extends('admin.layouts.app')

@section('title', 'Detail Pendaftar - ' . $pendaftar->nama_lengkap)

@section('content')
<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Detail Pendaftar</h2>
            <p class="text-gray-600">#{{ $pendaftar->id }} - {{ $pendaftar->nama_lengkap }}</p>
        </div>
        <a href="{{ route('admin.pendaftar') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    {{-- Profil Card --}}
    <div class="grid lg:grid-cols-2 gap-8 mb-12">
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
            <div class="flex items-start space-x-6 mb-8">
                <div class="flex-shrink-0">
                    @if($pendaftar->pas_foto)
                        <img src="{{ $pendaftar->pas_foto_url }}" class="w-32 h-32 rounded-2xl object-cover shadow-xl border-4 border-white">
                    @else
                        <div class="w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center shadow-xl border-4 border-white">
                            <i class="fas fa-user text-4xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $pendaftar->nama_lengkap }}</h3>
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-xl font-semibold text-sm">
                            {{ $pendaftar->nisn }}
                        </span>
                        <span class="status-badge px-4 py-2 rounded-full text-xs font-semibold 
                            @if($pendaftar->status == 'approved') bg-green-100 text-green-800 @elseif($pendaftar->status == 'rejected') bg-red-100 text-red-800 @else bg-orange-100 text-orange-800 @endif">
                            {{ ucfirst($pendaftar->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- FORM UPDATE STATUS - HTML BIASA (NO AJAX!) --}}
            <div class="border-t border-gray-100 pt-6 bg-gray-50 p-6 rounded-xl">
                <h4 class="font-semibold text-lg mb-6 flex items-center text-gray-900">
                    <i class="fas fa-toggle-on mr-2 text-blue-500"></i>Ubah Status Pendaftaran
                </h4>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-200 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <span class="font-semibold text-green-800">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.pendaftar.status', $pendaftar->id) }}" class="flex flex-wrap items-center gap-4">
                    @csrf
                    @method('PATCH')
                    
                    <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border shadow-sm">
                        <span class="text-sm font-medium text-gray-600 w-24">Status:</span>
                        <select name="status" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-200 focus:border-blue-400 font-semibold text-sm" onchange="this.form.submit()">
                            <option value="pending" {{ $pendaftar->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="approved" {{ $pendaftar->status == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                            <option value="rejected" {{ $pendaftar->status == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Update Status</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Kontak Card --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 space-y-6">
            <div>
                <h4 class="font-semibold text-lg mb-4 flex items-center text-gray-900">
                    <i class="fas fa-phone mr-2 text-green-500"></i>Hubungi Calon Siswa
                </h4>
                <div class="space-y-3">
                    <a href="https://wa.me/{{ str_replace(' ', '', $pendaftar->nomor_hp) }}?text=Halo%20{{ urlencode($pendaftar->nama_lengkap) }}%2C%20status%20pendaftaran%20Anda%20{{ $pendaftar->status }}%20✅" 
                       class="flex items-center p-4 bg-green-50 border-2 border-green-100 rounded-2xl hover:bg-green-100 transition-all group" 
                       target="_blank">
                        <i class="fab fa-whatsapp text-2xl text-green-500 mr-4 group-hover:animate-bounce"></i>
                        <div>
                            <div class="font-bold text-lg text-gray-900">{{ $pendaftar->nomor_hp }}</div>
                            <div class="text-sm text-green-700 font-medium">WhatsApp</div>
                        </div>
                    </a>
                    <a href="mailto:{{ $pendaftar->email }}" class="flex items-center p-4 bg-blue-50 border-2 border-blue-100 rounded-2xl hover:bg-blue-100 transition-all">
                        <i class="fas fa-envelope text-2xl text-blue-500 mr-4"></i>
                        <div>
                            <div class="font-bold text-lg text-gray-900">{{ $pendaftar->email }}</div>
                            <div class="text-sm text-blue-700 font-medium">Email</div>
                        </div>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-semibold text-lg mb-4 flex items-center text-gray-900">
                    <i class="fas fa-briefcase mr-2 text-purple-500"></i>Kompetensi Keahlian
                </h4>
                <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border-2 border-indigo-200">
                    <span class="text-xl font-bold text-indigo-900 block">{{ $pendaftar->kompetensi_keahlian }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Lengkap --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-blue-50">
            <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-file-invoice mr-3 text-blue-500"></i>Informasi Lengkap
            </h3>
        </div>
        <div class="p-8 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">NISN</label>
                <p class="text-xl font-bold text-gray-900 bg-gray-50 px-4 py-2 rounded-xl">{{ $pendaftar->nisn }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Asal Sekolah</label>
                <p class="text-lg font-semibold text-gray-900">{{ $pendaftar->asal_sekolah }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Jenis Kelamin</label>
                <p class="text-lg font-bold text-gray-900 capitalize">{{ $pendaftar->jenis_kelamin }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">TTL</label>
                <p class="text-lg font-semibold text-gray-900">{{ $pendaftar->tempat_lahir }}, {{ $pendaftar->tanggal_lahir->format('d F Y') }}</p>
            </div>
            <div class="lg:col-span-2">
                <label class="block text-sm font-semibold text-gray-600 mb-2">Alamat Lengkap</label>
                <p class="text-lg leading-relaxed text-gray-900 bg-gray-50 p-4 rounded-xl border">{{ $pendaftar->alamat_lengkap }}</p>
            </div>
            @if($pendaftar->mitra_pendaftaran)
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Mitra</label>
                <p class="text-lg font-semibold text-amber-800 bg-amber-100 px-4 py-2 rounded-xl border border-amber-200">
                    {{ $pendaftar->mitra_pendaftaran }}
                </p>
            </div>
            @endif
        </div>
    </div>

    {{-- Dokumen Pendaftar --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden mt-8">
        <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-indigo-50">
            <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-folder-open mr-3 text-indigo-500"></i>Dokumen Pendaftar
            </h3>
        </div>

        <div class="p-8 grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- KK --}}
            <div class="bg-gray-50 border rounded-2xl p-5">
                <h4 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-file-alt text-blue-500 mr-2"></i>Kartu Keluarga
                </h4>

                @if($pendaftar->kk)

                    <div class="space-y-2 mb-5">

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ukuran Asli</span>
                            <span class="font-semibold text-gray-800">
                                {{ number_format($pendaftar->kk_original_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Setelah Compress</span>
                            <span class="font-semibold text-green-600">
                                {{ number_format($pendaftar->kk_compressed_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Hemat</span>
                            <span class="font-bold text-blue-600">
                                {{ number_format((($pendaftar->kk_original_size - $pendaftar->kk_compressed_size) / $pendaftar->kk_original_size) * 100, 1) }}%
                            </span>
                        </div>

                    </div>

                    <a href="{{ asset('storage/' . $pendaftar->kk) }}"
                    target="_blank"
                    class="inline-flex items-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all">
                        <i class="fas fa-eye mr-2"></i>Lihat KK
                    </a>

                @else
                    <p class="text-sm text-red-500">File tidak tersedia</p>
                @endif
            </div>

            {{-- IJAZAH --}}
            <div class="bg-gray-50 border rounded-2xl p-5">
                <h4 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-graduation-cap text-green-500 mr-2"></i>Ijazah
                </h4>

                @if($pendaftar->ijazah)

                    <div class="space-y-2 mb-5">

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ukuran Asli</span>
                            <span class="font-semibold text-gray-800">
                                {{ number_format($pendaftar->ijazah_original_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Setelah Compress</span>
                            <span class="font-semibold text-green-600">
                                {{ number_format($pendaftar->ijazah_compressed_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Hemat</span>
                            <span class="font-bold text-green-600">
                                {{ number_format((($pendaftar->ijazah_original_size - $pendaftar->ijazah_compressed_size) / $pendaftar->ijazah_original_size) * 100, 1) }}%
                            </span>
                        </div>

                    </div>

                    <a href="{{ asset('storage/' . $pendaftar->ijazah) }}"
                    target="_blank"
                    class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-all">
                        <i class="fas fa-eye mr-2"></i>Lihat Ijazah
                    </a>

                @else
                    <p class="text-sm text-red-500">File tidak tersedia</p>
                @endif
            </div>

            {{-- SKL --}}
            <div class="bg-gray-50 border rounded-2xl p-5">
                <h4 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-file-signature text-orange-500 mr-2"></i>SKL
                </h4>

                @if($pendaftar->skl)

                    <div class="space-y-2 mb-5">

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ukuran Asli</span>
                            <span class="font-semibold text-gray-800">
                                {{ number_format($pendaftar->skl_original_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Setelah Compress</span>
                            <span class="font-semibold text-green-600">
                                {{ number_format($pendaftar->skl_compressed_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Hemat</span>
                            <span class="font-bold text-orange-600">
                                {{ number_format((($pendaftar->skl_original_size - $pendaftar->skl_compressed_size) / $pendaftar->skl_original_size) * 100, 1) }}%
                            </span>
                        </div>

                    </div>

                    <a href="{{ asset('storage/' . $pendaftar->skl) }}"
                    target="_blank"
                    class="inline-flex items-center px-5 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-semibold transition-all">
                        <i class="fas fa-eye mr-2"></i>Lihat SKL
                    </a>

                @else
                    <p class="text-sm text-red-500">File tidak tersedia</p>
                @endif
            </div>

            {{-- KIP --}}
            <div class="bg-gray-50 border rounded-2xl p-5">
                <h4 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-id-card text-purple-500 mr-2"></i>KIP
                </h4>

                @if($pendaftar->kip)

                    <div class="space-y-2 mb-5">

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ukuran Asli</span>
                            <span class="font-semibold text-gray-800">
                                {{ number_format($pendaftar->kip_original_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Setelah Compress</span>
                            <span class="font-semibold text-green-600">
                                {{ number_format($pendaftar->kip_compressed_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Hemat</span>
                            <span class="font-bold text-purple-600">
                                {{ number_format((($pendaftar->kip_original_size - $pendaftar->kip_compressed_size) / $pendaftar->kip_original_size) * 100, 1) }}%
                            </span>
                        </div>

                    </div>

                    <a href="{{ asset('storage/' . $pendaftar->kip) }}"
                    target="_blank"
                    class="inline-flex items-center px-5 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-semibold transition-all">
                        <i class="fas fa-eye mr-2"></i>Lihat KIP
                    </a>

                @else
                    <p class="text-sm text-red-500">File tidak tersedia</p>
                @endif
            </div>

            {{-- PAS FOTO --}}
            <div class="bg-gray-50 border rounded-2xl p-5">
                <h4 class="font-bold text-gray-800 mb-4">
                    <i class="fas fa-image text-pink-500 mr-2"></i>Pas Foto
                </h4>

                @if($pendaftar->pas_foto)

                    <div class="space-y-2 mb-5">

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ukuran Asli</span>
                            <span class="font-semibold text-gray-800">
                                {{ number_format($pendaftar->pas_foto_original_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Setelah Compress</span>
                            <span class="font-semibold text-green-600">
                                {{ number_format($pendaftar->pas_foto_compressed_size / 1024, 2) }} KB
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Hemat</span>
                            <span class="font-bold text-pink-600">
                                {{ number_format((($pendaftar->pas_foto_original_size - $pendaftar->pas_foto_compressed_size) / $pendaftar->pas_foto_original_size) * 100, 1) }}%
                            </span>
                        </div>

                    </div>

                    <a href="{{ asset('storage/' . $pendaftar->pas_foto) }}"
                    target="_blank"
                    class="inline-flex items-center px-5 py-3 bg-pink-600 hover:bg-pink-700 text-white rounded-xl font-semibold transition-all">
                        <i class="fas fa-eye mr-2"></i>Lihat Pas Foto
                    </a>

                @else
                    <p class="text-sm text-red-500">File tidak tersedia</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection