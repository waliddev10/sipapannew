<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanksiBungaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanksi_bunga', function (Blueprint $table) {
            $table->string('id', 36)->primary();                            // uuid v4
            $table->float('nilai', 5, 4)->unsigned(true);                   // nilai persen sanksi dalam decimal 0,0000
            $table->integer('hari_min')->unsigned(true);                    // batas bawah hari dikenakan sanksi setelah pelaporan
            $table->integer('hari_max')->unsigned(true);                    // batas atas hari kerja dikenakan sanksi
            $table->integer('hari_pembagi')->unsigned(true)->default(30);   // pembagi hari (default 30 hari atau sebulan)
            $table->date('tgl_berlaku');                                    // tgl dasar hukum diberlakukannya sanksi bunga
            $table->string('keterangan')->nullable();                       // keterangan
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
        Schema::dropIfExists('sanksi_bunga');
    }
}
