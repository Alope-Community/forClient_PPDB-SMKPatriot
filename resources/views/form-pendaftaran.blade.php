<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online - Sekolah Unggul</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-100 min-h-screen font-inter">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">PPDB Online</h1>
                        <p class="text-xs text-gray-500 font-medium">Penerimaan Peserta Didik Baru 2024</p>
                    </div>
                </div>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-clock mr-1"></i>
                    Buka hingga 31 Juli 2024
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-6 py-3 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold mb-6">
                <i class="fas fa-star mr-2"></i>
                Pendaftaran Online Gratis & Cepat
            </div>
            <h2 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-900 via-blue-900 to-indigo-900 bg-clip-text text-transparent mb-4">
                Daftar Sekarang
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Isi formulir dengan data yang lengkap dan benar. Pastikan semua informasi sesuai dengan dokumen resmi.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 overflow-hidden">
            <div class="p-8 lg:p-12">
                @if ($errors->any())
                    <div class="mb-8 p-6 rounded-2xl bg-red-50 border-2 border-red-200">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                            <div>
                                <h3 class="font-semibold text-red-800 mb-2">Ada kesalahan dalam pengisian:</h3>
                                <ul class="text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="fas fa-circle mr-2 text-xs"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <!-- Nama Lengkap -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2"></i>
                                Nama Lengkap *
                            </label>
                            <input 
                                type="text" 
                                name="nama_lengkap" 
                                value="{{ old('nama_lengkap') }}"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('nama_lengkap') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                                placeholder="Masukkan nama lengkap sesuai ijazah"
                                required
                            >
                            <p class="mt-1 text-xs text-gray-500">Masukkan nama lengkap sesuai ijazah</p>
                        </div>

                        <!-- NISN -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-id-card text-green-500 mr-2"></i>
                                NISN *
                            </label>
                            <input 
                                type="text" 
                                name="nisn" 
                                value="{{ old('nisn') }}"
                                maxlength="10"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('nisn') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                                placeholder="Masukkan 10 digit NISN"
                                required
                            >
                            <p class="mt-1 text-xs text-gray-500">Masukkan 10 digit NISN</p>
                        </div>
                    </div>

                    <!-- Tempat & Tanggal Lahir -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i>
                                Tempat Lahir *
                            </label>
                            <input 
                                type="text" 
                                name="tempat_lahir" 
                                value="{{ old('tempat_lahir') }}"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-purple-100 focus:border-purple-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('tempat_lahir') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                                placeholder="Masukkan tempat lahir"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-calendar text-orange-500 mr-2"></i>
                                Tanggal Lahir *
                            </label>
                            <input 
                                type="date" 
                                name="tanggal_lahir" 
                                value="{{ old('tanggal_lahir') }}"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-orange-100 focus:border-orange-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('tanggal_lahir') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                                required
                            >
                        </div>
                    </div>

                    <!-- Asal Sekolah & Jenis Kelamin -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-school text-indigo-500 mr-2"></i>
                                Asal Sekolah *
                            </label>
                            <input 
                                type="text" 
                                name="asal_sekolah" 
                                value="{{ old('asal_sekolah') }}"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('asal_sekolah') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                                placeholder="Nama sekolah SMP/MTs asal"
                                required
                            >
                            <p class="mt-1 text-xs text-gray-500">Nama sekolah SMP/MTs asal</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-venus-mars text-pink-500 mr-2"></i>
                                Jenis Kelamin *
                            </label>
                            <select 
                                name="jenis_kelamin"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-pink-100 focus:border-pink-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('jenis_kelamin') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                                required
                            >
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                                Nomor HP (WhatsApp) *
                            </label>
                            <input 
                                type="tel" 
                                name="nomor_hp" 
                                value="{{ old('nomor_hp') }}"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('nomor_hp') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                                placeholder="08xxxxxxxxxx"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                Email *
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('email') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                                placeholder="contoh@email.com"
                                required
                            >
                        </div>
                    </div>

                    <!-- Kompetensi Keahlian -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tools text-yellow-500 mr-2"></i>
                            Kompetensi Keahlian *
                        </label>
                        <select 
                            name="kompetensi_keahlian"
                            class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm @error('kompetensi_keahlian') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                            required
                        >
                            <option value="">Pilih kompetensi keahlian</option>
                            <option value="Teknik Komputer dan Jaringan" {{ old('kompetensi_keahlian') == 'Teknik Komputer dan Jaringan' ? 'selected' : '' }}>Teknik Komputer dan Jaringan</option>
                            <option value="Rekayasa Perangkat Lunak" {{ old('kompetensi_keahlian') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                            <option value="Multimedia" {{ old('kompetensi_keahlian') == 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                            <option value="Akuntansi dan Keuangan" {{ old('kompetensi_keahlian') == 'Akuntansi dan Keuangan' ? 'selected' : '' }}>Akuntansi dan Keuangan</option>
                            <option value="Tata Busana" {{ old('kompetensi_keahlian') == 'Tata Busana' ? 'selected' : '' }}>Tata Busana</option>
                        </select>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-map text-teal-500 mr-2"></i>
                            Alamat Lengkap *
                        </label>
                        <textarea 
                            name="alamat_lengkap" 
                            rows="3"
                            class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-teal-100 focus:border-teal-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm resize-vertical @error('alamat_lengkap') border-red-300 focus:ring-red-100 focus:border-red-400 @enderror"
                            placeholder="Masukkan alamat lengkap (RT/RW, Desa, Kecamatan, Kabupaten)"
                            required
                        >{{ old('alamat_lengkap') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Masukkan alamat lengkap (RT/RW, Desa, Kecamatan, Kabupaten)</p>
                    </div>

                    <!-- Upload Foto -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-camera text-purple-500 mr-2"></i>
                            Upload Pas Foto *
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-blue-400 transition-all duration-300 hover:bg-blue-50 @error('pas_foto') border-red-300 bg-red-50/50 @enderror">
                            <input 
                                type="file" 
                                name="pas_foto" 
                                accept="image/jpeg,image/png,image/jpg"
                                class="hidden"
                                id="pas_foto"
                                required
                            >
                            <label for="pas_foto" class="cursor-pointer block">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4 block"></i>
                                <p class="text-lg font-semibold text-gray-700 mb-1">Klik untuk upload pas foto</p>
                                <p class="text-sm text-gray-500 mb-4">Format: JPG, PNG. Maksimal 8MB</p>
                            </label>
                            <div id="file-name" class="text-sm font-medium text-blue-600 mt-2 hidden">
                                <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                File terpilih
                            </div>
                        </div>
                    </div>

                    <!-- Mitra -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-handshake text-amber-500 mr-2"></i>
                            Mitra Pendaftaran
                        </label>
                        <input 
                            type="text" 
                            name="mitra_pendaftaran" 
                            value="{{ old('mitra_pendaftaran') }}"
                            class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-amber-100 focus:border-amber-400 transition-all duration-300 bg-white/50 backdrop-blur-sm shadow-sm"
                            placeholder="Masukkan nama mitra (opsional)"
                        >
                        <p class="mt-1 text-xs text-gray-500">Masukkan nama mitra (opsional)</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-8">
                        <button 
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-6 px-8 rounded-2xl text-lg shadow-xl hover:from-blue-700 hover:to-indigo-700 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-3 group"
                        >
                            <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                            <span>Daftarkan Sekarang</span>
                            <div class="w-6 h-6 border-2 border-white/30 rounded-full animate-spin-slow hidden group-hover:block"></div>
                        </button>
                        {{-- <p class="text-center text-xs text-gray-500 mt-4">
                            <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                            Data Anda aman dan terlindungi
                        </p> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // File upload preview
        document.getElementById('pas_foto').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const fileNameDiv = document.getElementById('file-name');
            
            if (fileName) {
                fileNameDiv.textContent = fileName;
                fileNameDiv.classList.remove('hidden');
            }
        });

        // Auto format NISN
        document.querySelector('input[name="nisn"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });

        // Auto format nomor HP
        document.querySelector('input[name="nomor_hp"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,12})/, '$1');
            if (this.value && !this.value.startsWith('08')) {
                this.value = '08' + this.value.slice(2);
            }
        });
    </script>

    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 2s linear infinite;
        }
    </style>
</body>
</html>