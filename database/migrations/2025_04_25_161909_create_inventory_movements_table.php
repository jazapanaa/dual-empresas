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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('movement_type_id')->constrained('movement_types')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 10, 2);
            $table->dateTime('movement_date');
            $table->string('reference')->nullable(); // Referencia de la operación (ej. factura, remito, etc.)
            $table->text('notes')->nullable(); // Notas adicionales sobre el movimiento
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que realizó el movimiento

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
