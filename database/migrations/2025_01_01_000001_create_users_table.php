<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('users', function(Blueprint $table){
            $table->id();
            $table->string('nama_lengkap',100);
            $table->string('username',50)->unique();
            $table->unsignedBigInteger('role_id');
            $table->string('password',64);
            $table->enum('status',['aktif','nonaktif'])->default('aktif');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }
    public function down(){ Schema::dropIfExists('users'); }
};