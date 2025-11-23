<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('absensi', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status',['HADIR','TERLAMBAT','SAKIT','IZIN','ALPHA'])->default('HADIR');
            $table->enum('verifikasi_owner',['Belum Diverifikasi','Diverifikasi','Ditolak'])->default('Belum Diverifikasi');
            $table->string('catatan',200)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
    public function down(){ Schema::dropIfExists('absensi'); }
};