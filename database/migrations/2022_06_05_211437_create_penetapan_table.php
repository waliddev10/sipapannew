<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenetapanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penetapan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaporan_id');
            $table->string('no_penetapan')->nullable();
            $table->date('tgl_penetapan');
            $table->unsignedBigInteger('penandatangan_id');
            $table->unsignedBigInteger('kota_penandatangan_id');
            $table->timestamps();

            $table->foreign('pelaporan_id')
                ->references('id')
                ->on('pelaporan')
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
        Schema::dropIfExists('penetapan');
    }
}
