<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            /**
             * PAS FOTO
             */
            $table->bigInteger('pas_foto_original_size')->nullable();
            $table->bigInteger('pas_foto_compressed_size')->nullable();

            /**
             * KK
             */
            $table->bigInteger('kk_original_size')->nullable();
            $table->bigInteger('kk_compressed_size')->nullable();

            /**
             * IJAZAH
             */
            $table->bigInteger('ijazah_original_size')->nullable();
            $table->bigInteger('ijazah_compressed_size')->nullable();

            /**
             * SKL
             */
            $table->bigInteger('skl_original_size')->nullable();
            $table->bigInteger('skl_compressed_size')->nullable();

            /**
             * KIP
             */
            $table->bigInteger('kip_original_size')->nullable();
            $table->bigInteger('kip_compressed_size')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {

            $table->dropColumn([
                'pas_foto_original_size',
                'pas_foto_compressed_size',

                'kk_original_size',
                'kk_compressed_size',

                'ijazah_original_size',
                'ijazah_compressed_size',

                'skl_original_size',
                'skl_compressed_size',

                'kip_original_size',
                'kip_compressed_size',
            ]);
        });
    }
};