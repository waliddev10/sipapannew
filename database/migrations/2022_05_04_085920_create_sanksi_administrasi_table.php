<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanksiAdministrasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanksi_administrasi', function (Blueprint $table) {
            $table->id();            // uuid v4
            $table->bigInteger('nilai')->unsigned(true);    // nilai sanksi dalam rupiah
            $table->integer('tgl_batas')->unsigned(true);   // tgl batas pelaporan awal perbulan
            $table->integer('hari_min')->unsigned(true);    // hari kerja batas pelaporan
            $table->date('tgl_berlaku');                    // tgl sejak kapan sanksi berlaku
            $table->string('keterangan')->nullable();       // keterangan sanksi administrasi
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
        Schema::dropIfExists('sanksi_administrasi');
    }
}
