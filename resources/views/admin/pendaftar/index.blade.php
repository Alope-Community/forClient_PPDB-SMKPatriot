@extends('admin.layouts.app')

@section('title', 'Daftar Pendaftar')

@section('content')
<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Pendaftar</h2>
            <p class="text-gray-600">Kelola semua pendaftaran peserta didik baru</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama atau NISN..." 
                       class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-200 focus:border-blue-400 w-64">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Filter & Stats -->
    <div class="flex flex-col lg:flex-row gap-4 mb-8">
        <form method="GET" class="flex gap-2 bg-white p-4 rounded-2xl shadow-sm border">
            @foreach(request()->except(['status']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <select name="status" onchange="this.form.submit()" 
                    class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
        <div class="flex gap-4 text-sm">
            <span>Total: <strong>{{ $pendaftar->total() }}</strong></span>
            <span>Halaman: <strong>{{ $pendaftar->currentPage() }}</strong></span>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-12">#</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Data Pribadi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jurusan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftar as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $pendaftar->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            @if($item->pas_foto)
                                <img src="{{ $item->pas_foto_url }}" alt="Pas Foto" 
                                     class="w-12 h-12 rounded-full object-cover border-4 border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-sm"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ Str::limit($item->nama_lengkap, 20) }}</div>
                            <div class="text-sm text-gray-500">{{ $item->nisn }}</div>
                            <div class="text-xs text-gray-400">{{ $item->asal_sekolah }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->nomor_hp }}</div>
                            <div class="text-xs text-gray-500 truncate max-w-32">{{ $item->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                                {{ Str::limit($item->kompetensi_keahlian, 25) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-4 py-2 rounded-full text-xs font-semibold 
                                @if($item->status == 'approved') bg-green-100 text-green-800 @elseif($item->status == 'rejected') bg-red-100 text-red-800 @else bg-orange-100 text-orange-800 @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2 opacity-50 group-hover:opacity-100 transition-all">
                                <a href="{{ route('admin.pendaftar.show', $item) }}" 
                                   class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"
                                   title="Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center text-gray-500">
                            <i class="fas fa-users-slash text-5xl mb-4 block"></i>
                            <p>Belum ada pendaftaran</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $pendaftar->appends(request()->query())->links() }}
        </div>
    </div>
</div>

{{-- Custom Pagination Styles --}}
<style>
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    .pagination a, .pagination span {
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 500;
    }
    .pagination a:hover {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    .pagination .active a {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    .pagination .disabled a {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endsection