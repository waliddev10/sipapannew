<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaporanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelaporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('masa_pajak_id');
            $table->unsignedBigInteger('perusahaan_id');
            $table->date('tgl_pelaporan');
            $table->bigInteger('volume')->unsigned();
            $table->unsignedBigInteger('cara_pelaporan_id');
            $table->string('file');
            $table->unsignedBigInteger('penandatangan_id');
            $table->unsignedBigInteger('kota_penandatangan_id');
            $table->timestamps();

            $table->foreign('masa_pajak_id')
                ->references('id')
                ->on('masa_pajak')
                ->onDelete('cascade');
            $table->foreign('perusahaan_id')
                ->references('id')
                ->on('perusahaan')
                ->onDelete('cascade');
            $table->foreign('cara_pelaporan_id')
                ->references('id')
                ->on('cara_pelaporan')
                ->onDelete('cascade');
            $table->foreign('penandatangan_id')
                ->references('id')
                ->on('penandatangan')
                ->onDelete('cascade');
            $table->foreign('kota_penandatangan_id')
                ->references('id')
                ->on('kota_penandatangan')
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
        Schema::dropIfExists('pelaporan');
    }
}
