<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggalLiburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggal_libur', function (Blueprint $table) {
            $table->id();        // uuid v4
            $table->date('tgl_libur');                  // tgl libur kalender gubernur
            $table->string('keterangan');               // tanggal libur apa?
            $table->string('dasar_hukum')->nullable();  // dasar hukum
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
        Schema::dropIfExists('tanggal_libur');
    }
};
