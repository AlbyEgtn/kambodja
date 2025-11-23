<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('bahan_baku', function(Blueprint $table){
            $table->id();
            $table->string('nama_bahan',100);
            $table->integer('stok')->default(0);
            $table->string('satuan',20);
            $table->timestamps();
        });

        Schema::create('pembelian_bahan', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('bahan_id');
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->string('keterangan',200)->nullable();
            $table->foreign('bahan_id')->references('id')->on('bahan_baku')->cascadeOnDelete();
        });

        Schema::create('resep', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('bahan_id');
            $table->integer('jumlah_pakai');
            $table->foreign('menu_id')->references('id')->on('menu')->cascadeOnDelete();
            $table->foreign('bahan_id')->references('id')->on('bahan_baku')->cascadeOnDelete();
        });
    }
    public function down(){
        Schema::dropIfExists('resep');
        Schema::dropIfExists('pembelian_bahan');
        Schema::dropIfExists('bahan_baku');
    }
};