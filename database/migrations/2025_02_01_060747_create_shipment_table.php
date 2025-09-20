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
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ORDER_NUMBER', 10)->unique();
            $table->string('SENDER_CODE', 20)->nullable();
            $table->string('RECEIVER_CODE', 20)->nullable();
            $table->string('COURIER', 100)->nullable();
            $table->decimal('PRICE', 10, 2)->nullable();
            $table->string('PRICE_TYPE', 10)->nullable();
            $table->text('DETAILS')->nullable();
            $table->text('CONTACT_DETAILS')->nullable();
            $table->unsignedBigInteger('ID_USER')->nullable();
            $table->foreign('ID_USER')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
