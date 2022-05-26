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
            $table->string('id', 36)->primary();
            $table->string('masa_pajak_id', 36);
            $table->string('perusahaan_id', 36);
            $table->date('tgl_pelaporan');
            $table->bigInteger('volume')->unsigned();
            $table->string('cara_pelaporan_id', 36);
            $table->string('penandatangan_id', 36);
            $table->string('kota_penandatangan_id', 36);
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
