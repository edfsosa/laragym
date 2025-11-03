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
        Schema::create('equipment_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();
            $table->enum('type', ['preventive', 'corrective'])->default('preventive');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamp('performed_at')->nullable(); // Cuando se realizó el mantenimiento
            $table->timestamp('next_due_at')->nullable(); // Próxima fecha de mantenimiento
            $table->decimal('cost', 12, 2)->nullable(); // Costo del mantenimiento
            $table->string('vendor')->nullable(); // Proveedor o contratista
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenances');
    }
};
