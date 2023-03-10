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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transporter_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
        Schema::table('trips', function (Blueprint $table) {
            $table->foreign('transporter_id', 'fk-trips-transporter_id')
                ->on('transporters')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('order_id', 'fk-trips-order_id')
                ->on('orders')
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
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign('fk-trips-order_id');
            $table->dropForeign('fk-trips-transporter_id');
        });
        Schema::dropIfExists('trips');
    }
};
