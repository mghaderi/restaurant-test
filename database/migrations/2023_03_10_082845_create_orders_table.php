<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->integer('delivery_time')->nullable();
            $table->integer('extra_time')->nullable();
            $table->integer('extra_attempts')->nullable();
            $table->timestamps();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id', 'fk-orders-user_id')
                ->on('users')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('vendor_id', 'fk-orders-vendor_id')
                ->on('vendors')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('fk-orders-vendor_id');
            $table->dropForeign('fk-orders-user_id');
        });
        Schema::dropIfExists('orders');
    }
};
