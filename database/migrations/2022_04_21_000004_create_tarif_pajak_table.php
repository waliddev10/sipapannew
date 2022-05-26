<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifPajakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_pajak', function (Blueprint $table) {
            $table->id();            // uuid v4
            $table->float('nilai', 5, 4)->unsigned(true);   // tarif pajak dalam decimal: 0,0000
            $table->date('tgl_berlaku');                    // tgl sejak kapan tarif berlaku
            $table->string('keterangan')->nullable();       // keterangan tarif pajak
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
        Schema::dropIfExists('tarif_pajak');
    }
};
