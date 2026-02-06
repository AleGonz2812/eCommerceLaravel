<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique(); // Número de orden único (ej: ORD-20260127-A3B4C5)
            $table->decimal('total', 10, 2); // Total del pedido
            $table->string('status')->default('completed'); // completed, pending, cancelled
            $table->text('notes')->nullable(); // Notas adicionales
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('order_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
