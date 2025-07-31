<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penilaian_id');
            $table->foreign('penilaian_id')->references('id')->on('penilaian')->onDelete('cascade');
            $table->unsignedBigInteger('kriteria_id');
            $table->foreign('kriteria_id')->references('id')->on('kriteria')->onDelete('cascade');
            $table->unsignedBigInteger('crips_id');
            $table->foreign('crips_id')->references('id')->on('crips')->onDelete('cascade');
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
        Schema::dropIfExists('detail_penilaian');
    }
};
