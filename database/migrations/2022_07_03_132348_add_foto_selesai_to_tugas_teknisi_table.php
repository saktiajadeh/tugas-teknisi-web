<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoSelesaiToTugasTeknisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tugas_teknisi', function (Blueprint $table) {
            $table->string('foto_selesai')->nullable()->after('foto_mulai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tugas_teknisi', function (Blueprint $table) {
            $table->dropColumn('foto_selesai');
        });
    }
}
