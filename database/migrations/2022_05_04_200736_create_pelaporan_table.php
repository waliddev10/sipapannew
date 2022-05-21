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
            $table->timestamps();
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
