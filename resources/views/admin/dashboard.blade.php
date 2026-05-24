@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /**
         * DESTROY OLD CHARTS
         */
        if (window.jurusanChartInstance) {
            window.jurusanChartInstance.destroy();
        }

        if (window.compressChartInstance) {
            window.compressChartInstance.destroy();
        }

        /**
         * CHART JURUSAN
         */
        const jurusanCtx = document.getElementById('jurusanChart');

        if (jurusanCtx) {

            window.jurusanChartInstance = new Chart(jurusanCtx, {

                type: 'bar',

                data: {
                    labels: {!! json_encode($jurusanChart->keys()) !!},

                    datasets: [{
                        label: 'Jumlah Pendaftar',

                        data: {!! json_encode($jurusanChart->values()) !!},

                        borderWidth: 2,
                        borderRadius: 10,

                        backgroundColor: [
                            '#3B82F6',
                            '#10B981',
                            '#F59E0B',
                            '#EF4444',
                            '#8B5CF6'
                        ],

                        borderColor: [
                            '#2563EB',
                            '#059669',
                            '#D97706',
                            '#DC2626',
                            '#7C3AED'
                        ]
                    }]
                },

                options: {
                    responsive: true,

                    plugins: {
                        legend: {
                            display: true
                        }
                    },

                    scales: {
                        y: {
                            beginAtZero: true,

                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        /**
         * CHART COMPRESS
         */
        const compressCtx = document.getElementById('compressChart');

        if (compressCtx) {

            const originalSize =
                {{ round($compress->original_size / 1024 / 1024, 2) }};

            const compressedSize =
                {{ round($compress->compressed_size / 1024 / 1024, 2) }};

            window.compressChartInstance = new Chart(compressCtx, {

                type: 'doughnut',

                data: {

                    labels: [
                        'Ukuran Asli',
                        'Setelah Compress'
                    ],

                    datasets: [{
                        data: [
                            originalSize,
                            compressedSize
                        ],

                        backgroundColor: [
                            '#EF4444',
                            '#10B981'
                        ],

                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },

                options: {

                    responsive: true,

                    cutout: '70%',

                    plugins: {

                        legend: {
                            position: 'bottom',

                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },

                        tooltip: {

                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' +
                                        context.raw + ' MB';
                                }
                            }
                        }
                    }
                }
            });
        }

    });
</script>

<div class="overflow-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h2>
        <p class="text-gray-600">Selamat datang kembali, {{ session('admin_username') }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Pendaftar</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-orange-600">{{ number_format($stats['pending']) }}</p>
                </div>
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-clock text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Approved</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($stats['approved']) }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Rejected</p>
                    <p class="text-3xl font-bold text-red-600">{{ number_format($stats['rejected']) }}</p>
                </div>
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-2xl text-red-600"></i>
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 mb-5 gap-10">

        <!-- CHART JURUSAN -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mt-8">
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Grafik Pendaftar per Jurusan
                    </h2>

                    <p class="text-sm text-gray-500">
                        Statistik jumlah pendaftar berdasarkan kompetensi keahlian
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                </div>

            </div>

            <canvas id="jurusanChart" height="150"></canvas>
        </div>

        <!-- COMPRESS IMAGE -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mt-8">

            <!-- HEADER -->
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Statistik Compress Gambar
                    </h2>

                    <p class="text-sm text-gray-500">
                        Monitoring optimasi ukuran upload pas foto
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="fas fa-compress-alt text-green-600 text-xl"></i>
                </div>

            </div>

            <!-- STATS -->
            <div class="grid grid-cols-2 gap-4 mb-6">

                <!-- TOTAL FILE -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-md">

                    <div class="flex items-center justify-between mb-3">

                        <div>
                            <p class="text-sm opacity-80">
                                Total File
                            </p>

                            <h3 class="text-3xl font-bold mt-1">
                                {{ $compress->total_files }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-images text-xl"></i>
                        </div>

                    </div>

                </div>

                <!-- RATIO -->
                <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-2xl p-5 text-white shadow-md">

                    <div class="flex items-center justify-between mb-3">

                        <div>
                            <p class="text-sm opacity-80">
                                Rasio Compress
                            </p>

                            <h3 class="text-3xl font-bold mt-1">
                                {{ number_format($compress->compression_ratio, 1) }}%
                            </h3>
                        </div>

                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-percentage text-xl"></i>
                        </div>

                    </div>

                </div>

                <!-- ORIGINAL SIZE -->
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-gray-500">
                                Ukuran Asli
                            </p>

                            <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                {{ number_format($compress->original_size / 1024 / 1024, 2) }} MB
                            </h3>
                        </div>

                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-file-image text-red-500 text-xl"></i>
                        </div>

                    </div>

                </div>

                <!-- COMPRESSED SIZE -->
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-gray-500">
                                Setelah Compress
                            </p>

                            <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                {{ number_format($compress->compressed_size / 1024 / 1024, 2) }} MB
                            </h3>
                        </div>

                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-compress text-green-500 text-xl"></i>
                        </div>

                    </div>

                </div>

            </div>

            <!-- CHART -->
           {{-- <div class="bg-gray-50 rounded-2xl p-4">
                <div class="">
                    <canvas id="compressChart" style="height: 100px"></canvas>
                </div>
            </div> --}}

        </div>

    </div>

    <!-- Recent Pendaftar -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pendaftar Terbaru</h3>
            <p class="text-gray-600">{{ $stats['today'] }} pendaftar hari ini</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-8 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NISN</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recent as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="font-semibold text-gray-900">{{ Str::limit($item->nama_lengkap, 25) }}</div>
                            <div class="text-sm text-gray-500">{{ $item->asal_sekolah }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="bg-gray-100 px-3 py-1 rounded-full text-sm font-medium text-gray-800">{{ $item->nisn }}</span>
                        </td>
                        <td class="px-4 py-4">
                            @php $statusClass = ['pending' => 'orange', 'approved' => 'green', 'rejected' => 'red']; @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                @if($item->status == 'approved') bg-green-100 text-green-800 @elseif($item->status == 'rejected') bg-red-100 text-red-800 @else bg-orange-100 text-orange-800 @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            {{ $item->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2 block"></i>
                            Belum ada pendaftaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-4 border-t border-gray-100 bg-gray-50">
            <a href="{{ route('admin.pendaftar') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                Lihat semua pendaftar →
            </a>
        </div>
    </div>
</div>
@endsection