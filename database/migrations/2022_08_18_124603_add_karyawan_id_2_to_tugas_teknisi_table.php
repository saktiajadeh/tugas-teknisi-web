<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKaryawanId2ToTugasTeknisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tugas_teknisi', function (Blueprint $table) {
            $table->integer('karyawan_id_2')->nullable()->after('karyawan_id')->default(0);
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
            $table->dropColumn('karyawan_id_2');
        });
    }
}
