<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('transaksi', function(Blueprint $table){
            $table->id();
            $table->string('no_transaksi',50)->unique();
            $table->unsignedBigInteger('kasir_id');
            $table->dateTime('tanggal');
            $table->decimal('total_harga',12,2);
            $table->enum('metode_bayar',['CASH','QRIS','DEBIT','EWALLET'])->default('CASH');
            $table->timestamps();
            $table->foreign('kasir_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('transaksi_detail', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('menu_id');
            $table->integer('qty');
            $table->decimal('harga',12,2);
            $table->decimal('subtotal',12,2);
            $table->foreign('transaksi_id')->references('id')->on('transaksi')->cascadeOnDelete();
            $table->foreign('menu_id')->references('id')->on('menu')->cascadeOnDelete();
        });
    }
    public function down(){
        Schema::dropIfExists('transaksi_detail');
        Schema::dropIfExists('transaksi');
    }
};