<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasTeknisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_teknisi', function (Blueprint $table) {
            $table->id();
            $table->integer('pelanggan_id');
            $table->integer('kategori_jasa_id');
            $table->string('detail');

            $table->integer('karyawan_id');

            $table->time('jam_mulai')->nullable();
            $table->date('tanggal_mulai')->nullable();

            $table->time('jam_selesai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->string('foto_mulai')->nullable();

            $table->enum('status',['nostatus', 'progress', 'finish'])->default('nostatus');

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
        Schema::dropIfExists('tugas_teknisi');
    }
}
