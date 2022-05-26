<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('npa', function (Blueprint $table) {
            $table->id();                            // uuid v4
            $table->bigInteger('volume_min')->unsigned(true)->nullable();   // volume min NPA
            $table->bigInteger('volume_max')->unsigned(true)->nullable();   // volume max NPA
            $table->float('nilai', 15, 2)->unsigned(true);                  // nilai NPA
            $table->unsignedBigInteger('jenis_usaha_id');                           // jenis usaha
            $table->date('tgl_berlaku');                                    // tgl diberlakukannya NPA
            $table->string('keterangan')->nullable();                       // keterangan
            $table->timestamps();

            $table->foreign('jenis_usaha_id')
                ->references('id')
                ->on('jenis_usaha')
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
        Schema::dropIfExists('npa');
    }
};
