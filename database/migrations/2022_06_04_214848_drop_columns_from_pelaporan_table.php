<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsFromPelaporanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelaporan', function (Blueprint $table) {
            $table->dropForeign(['penandatangan_id']);
            $table->dropForeign(['kota_penandatangan_id']);

            $table->dropColumn('penandatangan_id');
            $table->dropColumn('kota_penandatangan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelaporan', function (Blueprint $table) {
            $table->unsignedBigInteger('penandatangan_id')->nullable();
            $table->unsignedBigInteger('kota_penandatangan_id')->nullable();

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
}
