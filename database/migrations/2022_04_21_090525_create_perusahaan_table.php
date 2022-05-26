<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->string('id', 36)->primary();    // uuid v4
            $table->string('nama');                 // nama perusahaan
            $table->string('alamat');               // alamat perusahaan
            $table->date('tgl_penetapan');          // tgl penetapan sebagai PKP
            $table->string('hp_pj');                // nomor hp contact person
            $table->string('nama_pj');              // nama contact person
            $table->string('jenis_usaha_id', 36);   // jenis usaha perusahaan
            $table->string('email', 64);            // alamat email perusahaan
            $table->timestamps();

            $table->foreign('jenis_usaha_id')
                ->references('id')
                ->on('jenis_usaha')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perusahaan');
    }
};
