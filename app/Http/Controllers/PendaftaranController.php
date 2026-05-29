<?php

namespace App\Http\Controllers;

use App\Models\CompressStat;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('user.form-pendaftaran');
    }

    // public function store(Request $request)
    // {
    //     try {

    //         /**
    //          * VALIDASI
    //          */
    //         $validator = Validator::make($request->all(), [
    //             'nama_lengkap' => 'required|string|max:255',
    //             'nisn' => 'required|string|size:10|unique:pendaftarans,nisn',
    //             'tempat_lahir' => 'required|string|max:100',
    //             'tanggal_lahir' => 'required|date',
    //             'asal_sekolah' => 'required|string|max:255',
    //             'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
    //             'nomor_hp' => 'required|string|regex:/^08[0-9]{8,12}$/',
    //             'email' => 'required|email|unique:pendaftarans,email',
    //             'kompetensi_keahlian' => 'required|string',
    //             'alamat_lengkap' => 'required|string',
    //             'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:8192',
    //             'mitra_pendaftaran' => 'nullable|string|max:255'
    //         ]);

    //         if ($validator->fails()) {
    //             return back()
    //                 ->withErrors($validator)
    //                 ->withInput();
    //         }

    //         /**
    //          * AMBIL DATA
    //          */
    //         $data = $request->except('pas_foto');

    //         /**
    //          * UPLOAD & COMPRESS FOTO
    //          */
    //         if ($request->hasFile('pas_foto')) {

    //             $foto = $request->file('pas_foto');

    //             // Nama file
    //             $filename = 'pasfoto_' . time() . '_' . $request->nisn . '.jpg';

    //             // Ukuran file asli
    //             $originalSize = $foto->getSize();

    //             // Folder tujuan
    //             $destination = storage_path('app/public/pas_foto');

    //             // Buat folder jika belum ada
    //             if (!file_exists($destination)) {
    //                 mkdir($destination, 0777, true);
    //             }

    //             // Path simpan
    //             $savePath = $destination . '/' . $filename;

    //             /**
    //              * COMPRESS IMAGE
    //              */
    //             $image = Image::make($foto);

    //             // Resize lebar 600px
    //             $image->resize(600, null, function ($constraint) {
    //                 $constraint->aspectRatio();
    //                 $constraint->upsize();
    //             });

    //             // Simpan JPG kualitas 60%
    //             $image->save($savePath, 60, 'jpg');

    //             // Ukuran file setelah compress
    //             $compressedSize = filesize($savePath);

    //             // Simpan path ke database
    //             $data['pas_foto'] = 'pas_foto/' . $filename;

    //             /**
    //              * UPDATE STATISTIK COMPRESS
    //              */
    //             $stat = CompressStat::first();

    //             if (!$stat) {

    //                 $stat = CompressStat::create([
    //                     'original_size' => 0,
    //                     'compressed_size' => 0,
    //                     'total_files' => 0,
    //                     'compression_ratio' => 0
    //                 ]);
    //             }

    //             $stat->original_size += $originalSize;
    //             $stat->compressed_size += $compressedSize;
    //             $stat->total_files += 1;

    //             // Hitung penghematan
    //             $saved = $stat->original_size - $stat->compressed_size;

    //             // Hitung rasio compress
    //             $stat->compression_ratio =
    //                 $stat->original_size > 0
    //                     ? ($saved / $stat->original_size) * 100
    //                     : 0;

    //             $stat->save();
    //         }

    //         /**
    //          * SIMPAN DATA PENDAFTAR
    //          */
    //         Pendaftaran::create($data);

    //         return redirect()->back()
    //             ->with('success', 'Pendaftaran berhasil!');
    //     } catch (\Exception $e) {

    //         return back()->with(
    //             'error',
    //             $e->getMessage()
    //         );
    //     }
    // }
    public function store(Request $request)
    {
        try {

            /**
             * VALIDASI
             */
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

                'pas_foto' => 'required|file|mimes:jpeg,png,jpg|max:8192',

                'kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:8192',

                'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:8192',

                'skl' => 'required|file|mimes:pdf,jpg,jpeg,png|max:8192',

                'kip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:8192',

                'mitra_pendaftaran' => 'nullable|string|max:255'
            ]);

            /**
             * VALIDASI GAGAL
             */
            if ($validator->fails()) {

                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            /**
             * AMBIL DATA
             */
            $data = $request->except([
                'pas_foto',
                'kk',
                'ijazah',
                'skl',
                'kip'
            ]);

            /**
             * =========================================
             * UPLOAD PAS FOTO
             * =========================================
             */
            if ($request->hasFile('pas_foto')) {

                $data['pas_foto'] = $this->uploadCompressedFile(
                    $request->file('pas_foto'),
                    'pas_foto',
                    'pasfoto',
                    $request->nisn
                );
            }

            /**
             * =========================================
             * UPLOAD KK
             * =========================================
             */
            if ($request->hasFile('kk')) {

                $data['kk'] = $this->uploadCompressedFile(
                    $request->file('kk'),
                    'kk',
                    'kk',
                    $request->nisn
                );
            }

            /**
             * =========================================
             * UPLOAD IJAZAH
             * =========================================
             */
            if ($request->hasFile('ijazah')) {

                $data['ijazah'] = $this->uploadCompressedFile(
                    $request->file('ijazah'),
                    'ijazah',
                    'ijazah',
                    $request->nisn
                );
            }

            /**
             * =========================================
             * UPLOAD SKL
             * =========================================
             */
            if ($request->hasFile('skl')) {

                $data['skl'] = $this->uploadCompressedFile(
                    $request->file('skl'),
                    'skl',
                    'skl',
                    $request->nisn
                );
            }

            /**
             * =========================================
             * UPLOAD KIP
             * =========================================
             */
            if ($request->hasFile('kip')) {

                $data['kip'] = $this->uploadCompressedFile(
                    $request->file('kip'),
                    'kip',
                    'kip',
                    $request->nisn
                );
            }

            /**
             * SIMPAN DATA
             */
            Pendaftaran::create($data);

            return redirect()->back()
                ->with('success', 'Pendaftaran berhasil!');
        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    /**
     * =========================================
     * UPLOAD & COMPRESS FILE
     * =========================================
     */
    private function uploadCompressedFile($file, $folder, $prefix, $nisn)
    {
        /**
         * EXTENSION
         */
        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        /**
         * NAMA FILE
         */
        $filename = $prefix . '_' . time() . '_' . $nisn . '.' . $extension;

        /**
         * FOLDER STORAGE
         */
        $destination = storage_path(
            'app/public/' . $folder
        );

        /**
         * BUAT FOLDER
         */
        if (!file_exists($destination)) {

            mkdir($destination, 0777, true);
        }

        /**
         * SIZE ASLI
         */
        $originalSize = $file->getSize();

        /**
         * =========================================
         * FILE GAMBAR → COMPRESS
         * =========================================
         */
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {

            $savePath = $destination . '/' . $filename;

            /**
             * LOAD IMAGE
             */
            $image = Image::make($file);

            /**
             * RESIZE
             */
            $image->resize(900, null, function ($constraint) {

                $constraint->aspectRatio();

                $constraint->upsize();
            });

            /**
             * SAVE COMPRESSED
             */
            if ($extension == 'png') {

                $image->save(
                    $savePath,
                    60,
                    'png'
                );
            } else {

                $image->save(
                    $savePath,
                    60,
                    'jpg'
                );
            }

            /**
             * SIZE HASIL COMPRESS
             */
            $compressedSize = filesize($savePath);
        } else {

            /**
             * PDF / FILE LAIN
             */
            $file->storeAs(
                $folder,
                $filename,
                'public'
            );

            $compressedSize = $originalSize;
        }

        /**
         * =========================================
         * UPDATE STATISTIK
         * =========================================
         */
        $stat = CompressStat::first();

        if (!$stat) {

            $stat = CompressStat::create([
                'original_size' => 0,
                'compressed_size' => 0,
                'total_files' => 0,
                'compression_ratio' => 0
            ]);
        }

        $stat->original_size += $originalSize;

        $stat->compressed_size += $compressedSize;

        $stat->total_files += 1;

        $saved = $stat->original_size - $stat->compressed_size;

        $stat->compression_ratio =
            $stat->original_size > 0
            ? ($saved / $stat->original_size) * 100
            : 0;

        $stat->save();

        /**
         * RETURN PATH
         */
        return $folder . '/' . $filename;
    }
}