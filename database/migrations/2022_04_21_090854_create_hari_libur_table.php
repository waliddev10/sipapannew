<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHariLiburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hari_libur', function (Blueprint $table) {
            $table->string('id', 36)->primary();        // uuid v4
            $table->date('tgl_libur');                  // tgl libur kalender gubernur
            $table->string('keterangan');               // hari libur apa?
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
        Schema::dropIfExists('hari_libur');
    }
};
