<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasaPajakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masa_pajak', function (Blueprint $table) {
            $table->string('id', 36)->primary();            // uuid v4
            $table->integer('bulan')->unsigned(true);       // bulan masa pajak (dalam angka)
            $table->integer('tahun')->unsigned(true);       // tahun masa pajak
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
        Schema::dropIfExists('masa_pajak');
    }
};
