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
        Schema::create('delay_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
        Schema::table('delay_orders', function (Blueprint $table) {
            $table->foreign('order_id', 'fk-delay_orders-order_id')
                ->on('orders')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('employee_id', 'fk-delay_orders-employee_id')
                ->on('users')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('trip_id', 'fk-delay_orders-trip_id')
                ->on('trips')
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
        Schema::table('delay_orders', function (Blueprint $table) {
            $table->dropForeign('fk-delay_orders-trip_id');
            $table->dropForeign('fk-delay_orders-employee_id');
            $table->dropForeign('fk-delay_orders-order_id');
        });
        Schema::dropIfExists('delay_orders');
    }
};
